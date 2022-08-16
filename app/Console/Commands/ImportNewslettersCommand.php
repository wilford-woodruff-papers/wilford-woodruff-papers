<?php

namespace App\Console\Commands;

use App\Models\Newsletter;
use App\Models\Oauth;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;

class ImportNewslettersCommand extends Command
{
    protected $signature = 'newsletters:import';

    protected $description = 'Import newsletters from Constant Contact';

    public function handle()
    {
        $url = 'https://api.cc.email/v3/emails?limit=50';

        $oauth = Oauth::query()
                        ->where('provider', 'Constant Contact')
                        ->first();

        if($oauth->expires_at < now()){
            $oauth = $this->refreshToken($oauth);
        }

        $token = $oauth->access_token;
        ray($token);
        $response = Http::withToken($token)
                            ->get($url);

        $newsletters = collect($response->json('campaigns'))->filter(function($item){
            return str($item['current_status'])->contains('Done');
        });

        $newsletters->each(function($item) use ($token){
            $newsletter = Newsletter::firstOrNew([
                'campaign_id' => $item['campaign_id'],
            ]);

            if(! $newsletter->exists){
                $url = 'https://api.cc.email/v3/emails/'. $newsletter->campaign_id;
                $response = Http::withToken($token)
                    ->get($url);
                if($campaign_activity_id = data_get(collect($response->json('campaign_activities'))->filter(function($item){
                    return $item['role'] == 'primary_email';
                })->first(), 'campaign_activity_id')){
                    $url = 'https://api.cc.email/v3/emails/activities/'. $campaign_activity_id . '?include=html_content%2Cpermalink_url';
                    $response = Http::withToken($token)
                        ->get($url);

                    $newsletter->save();
                    $newsletter->content = $this->replaceImages($response->json('html_content'), $newsletter);
                    $newsletter->subject = $item['subject'];
                    $newsletter->preheader = $response->json('preheader');
                    $newsletter->link = $response->json('permalink_url');
                    $newsletter->save();
                }
            }
        });
    }

    private function replaceImages($content, $newsletter)
    {
        $newsletter->clearMediaCollection();

        $dom = new Dom;
        $dom->loadStr($content);
        $content = Str::of($content);
        $images = $dom->find('img');
        foreach ($images as $image) {
            $this->info($image->getAttribute('src'));
            if(str($image->getAttribute('src'))->contains('constantcontact')){
                $localImage = $newsletter
                    ->addMediaFromUrl($image->getAttribute('src'))
                    ->toMediaCollection('images', 'updates');

                $content = $content->replace($image->getAttribute('src'), $localImage->getUrl());
            }
        }

        return $content;
    }

    private function refreshToken($oauth)
    {
        $clientId = config('services.constantcontact.client_id');
        $clientSecret = config('services.constantcontact.client_secret');

        $base = 'https://authz.constantcontact.com/oauth2/default/v1/token';
        $url = $base . '?refresh_token=' . $oauth->refresh_token . '&grant_type=refresh_token';

        $auth = $clientId . ':' . $clientSecret;

        $credentials = base64_encode($auth);
        $authorization = 'Basic ' . $credentials;

        $response = Http::asForm()
                            ->withHeaders([
                                'Authorization' => $authorization,
                            ])
                            ->acceptJson()
                            ->post($url);

        $oauth->expires_at = now()->addSeconds($response->json('expires_in'));
        $oauth->access_token = $response->json('access_token');
        $oauth->refresh_token = $response->json('refresh_token');
        $oauth->save();

        return $oauth;
    }
}

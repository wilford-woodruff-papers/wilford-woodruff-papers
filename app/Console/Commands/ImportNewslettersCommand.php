<?php

namespace App\Console\Commands;

use App\Models\Newsletter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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

        $token = DB::table('oauth')->where('provider', 'Constant Contact')->first()->access_token;

        $response = Http::withToken($token)
                            ->get($url);

        $newsletters = collect($response->json('campaigns'))->filter(function($item){
            return $item['type'] == 'NEWSLETTER' && $item['current_status'] == 'Done';
        });

        $newsletters->each(function($item) use ($token){
            $newsletter = Newsletter::firstOrCreate([
                'campaign_id' => $item['campaign_id'],
            ]);

            $url = 'https://api.cc.email/v3/emails/'. $newsletter->campaign_id;
            $response = Http::withToken($token)
                                ->get($url);
            $campaign_activity_id = collect($response->json('campaign_activities'))->filter(function($item){
                                        return $item['role'] == 'primary_email';
                                    })->first()['campaign_activity_id'];

            $url = 'https://api.cc.email/v3/emails/activities/'. $campaign_activity_id . '?include=html_content%2Cpermalink_url';
            $response = Http::withToken($token)
                                ->get($url);

            $newsletter->content = $this->replaceImages($response->json('html_content'), $newsletter);
            $newsletter->subject = $response->json('subject');
            $newsletter->preheader = $response->json('preheader');
            $newsletter->link = $response->json('permalink_url');
            $newsletter->save();
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
                    ->toMediaCollection('images');

                $content = $content->replace($image->getAttribute('src'), $localImage->getUrl());
            }
        }

        return $content;
    }
}

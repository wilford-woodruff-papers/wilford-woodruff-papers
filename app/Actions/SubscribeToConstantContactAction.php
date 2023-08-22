<?php

namespace App\Actions;

use App\Models\Oauth;
use Illuminate\Support\Facades\Http;

class SubscribeToConstantContactAction
{
    public function __construct()
    {
        //
    }

    public function execute($contact, $listMemberships)
    {
        $url = 'https://api.cc.email/v3/contacts/sign_up_form';

        $oauth = Oauth::query()
            ->where('provider', 'Constant Contact')
            ->first();

        if ($oauth->expires_at < now()) {
            $oauth = $this->refreshToken($oauth);
        }

        $token = $oauth->access_token;

        logger()->info(implode(' | ', $contact));
        logger()->info(implode(' | ', $listMemberships));

        $response = Http::withToken($token)
                            ->post($url, [
                                'email_address' => $contact['email'],
                                'first_name' => $contact['first_name'],
                                'last_name' => $contact['last_name'],
                                'list_memberships' => $listMemberships,
                            ]);
        logger($response->json());
    }

    private function refreshToken($oauth)
    {
        $clientId = config('services.constantcontact.client_id');
        $clientSecret = config('services.constantcontact.client_secret');

        $base = 'https://authz.constantcontact.com/oauth2/default/v1/token';
        $url = $base.'?refresh_token='.$oauth->refresh_token.'&grant_type=refresh_token';

        $auth = $clientId.':'.$clientSecret;

        $credentials = base64_encode($auth);
        $authorization = 'Basic '.$credentials;

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

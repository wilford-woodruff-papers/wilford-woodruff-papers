<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ConstantContactController extends Controller
{
    public function redirectToProvider(Request $request)
    {
        $scope = 'campaign_data contact_data';
        $clientId = config('services.constantcontact.client_id');
        $redirectURI = config('services.constantcontact.redirect_uri');
        $request->session()->put('state', $state = Str::random(40));

        $baseURL = "https://authz.constantcontact.com/oauth2/default/v1/authorize";
        $authURL = $baseURL . "?client_id=" . $clientId . "&scope=" . $scope . "+offline_access&response_type=code&state=" . $state . "&redirect_uri=" . $redirectURI;

        return redirect()->away($authURL);
    }

    public function handleProviderCallback(Request $request)
    {

        $code = $request->get('code');
        $clientId = config('services.constantcontact.client_id');
        $clientSecret = config('services.constantcontact.client_secret');
        $redirectURI = config('services.constantcontact.redirect_uri');



        $base = "https://authz.constantcontact.com/oauth2/default/v1/token";
        $url = $base . '?code=' . $code . '&redirect_uri=' . $redirectURI . '&grant_type=authorization_code';

        $auth = $clientId . ':' . $clientSecret;

        $credentials = base64_encode($auth);
        $authorization = 'Basic ' . $credentials;

        $response = Http::asForm()
                            ->withHeaders([
                                'Authorization' => $authorization,
                            ])
                            ->acceptJson()
                            ->post($url);

        if(! empty($response->json('access_token'))){
            DB::table('oauth')->upsert([[
                'provider' => 'Constant Contact',
                'token_type' => $response->json('token_type'),
                'expires_at' => now()->addSeconds($response->json('expires_in')),
                'access_token' => $response->json('access_token'),
                'scope' => $response->json('scope'),
                'refresh_token' => $response->json('refresh_token'),
                'id_token' => $response->json('id_token'),
                'created_at' => now(),
                'updated_at' => now(),
            ]], ['provider'], ['token_type', 'expires_at' , 'access_token', 'scope', 'refresh_token', 'id_token', 'updated_at']);
        }

        return $response->json();
    }
}

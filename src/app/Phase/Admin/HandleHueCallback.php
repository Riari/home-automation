<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Model\AppToken;
use App\Util\Session as SessionUtil;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class HandleHueCallback extends Phase
{
    public function handle(Dot $state): Response
    {
        $payload = $_GET;

        $appTokenData = [];

        {
            $clientId = Config::Get('app.hue.client_id');
            $clientSecret = Config::Get('app.hue.client_secret');
    
            $oauthClient = HttpClient::create([
                'base_uri' => 'https://api.meethue.com/v2/',
                'auth_basic' => [$clientId, $clientSecret]
            ]);
    
            $response = $oauthClient->request('POST', 'oauth2/token', [
                'body' => [
                    'grant_type' => 'authorization_code',
                    'code' => $payload['code']
                ]
            ]);
    
            $content = $response->toArray();
    
            $appTokenData = [
                'access_token' => $content['access_token'],
                'refresh_token' => $content['refresh_token'],
                'expires_at' => date("Y-m-d H:i:s", time() + $content['expires_in'])
            ];
        }

        {
            $apiClient = HttpClient::create([
                'base_uri' => 'https://api.meethue.com/route/api/',
                'auth_bearer' => $appTokenData['access_token']
            ]);

            $response = $apiClient->request('PUT', '0/config', [
                'json' => ['linkbutton' => true]
            ]);

            $test = $response->toArray();

            if ($response->getStatusCode() != Response::HTTP_OK)
            {
                SessionUtil::setFlash("Hue token update failed", 'error');
                return new RedirectResponse('/admin/dashboard');
            }

            $response = $apiClient->request('POST', '', [
                'json' => ['devicetype' => Config::get('app.hue.app_name')]
            ]);

            if ($response->getStatusCode() != Response::HTTP_OK)
            {
                SessionUtil::setFlash("Hue token update failed", 'error');
                return new RedirectResponse('/admin/dashboard');
            }

            $payload = $response->toArray();

            $appTokenData['username'] = $payload[0]['success']['username'];
        }

        $appToken = AppToken::updateOrCreate(
            ['app' => 'hue'],
            $appTokenData
        );

        SessionUtil::setFlash("Hue token updated");

        return new RedirectResponse('/admin/dashboard');
    }
}
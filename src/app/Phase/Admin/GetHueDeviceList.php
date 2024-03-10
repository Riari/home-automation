<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Model\AppToken;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\HttpOptions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetHueDeviceList extends Phase
{
    public function handle(Dot $state): Response
    {
        $client = HttpClient::create([
            'base_uri' => 'https://api.meethue.com/route/'
        ]);

        $appToken = AppToken::where('app', 'hue')->first();

        $response = $client->request('GET', 'clip/v2/resource/device', [
            'auth_bearer' => $appToken->access_token,
            'headers' => [
                'hue-application-key' => $appToken->username
            ]
        ]);

        return new JsonResponse(
            $response->toArray(),
            Response::HTTP_OK
        );
    }
}
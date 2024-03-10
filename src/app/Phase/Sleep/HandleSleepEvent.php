<?php

namespace App\Phase\Sleep;

use Adbar\Dot;
use App\Model\AppToken;
use Closure;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleSleepEvent extends Phase
{
    public function handle(Dot $state): Response
    {
        $payload = json_decode($this->request->getContent(), true);

        if ($payload['event'] != 'alarm_alert_start')
        {
            return new JsonResponse(
                ['error' => 'Invalid event'],
                Response::HTTP_BAD_REQUEST
            );
        }

        // TODO: Move all clients into service classes

        $fadeDuration = (int)(Config::get('app.lights.wake_duration'));

        // LIFX
        try
        {
            $client = HttpClient::create([
                'base_uri' => 'https://api.lifx.com/v1/',
                'auth_bearer' => Config::get('app.lifx.token')
            ]);

            $response = $client->request(
                'PUT',
                'lights/group:Bedroom/state',
                [
                    'json' => [
                        'power' => 'on',
                        'duration' => $fadeDuration,
                        'fast' => false
                    ]
                ]
            );

            $response->getContent();
        }
        catch (\Exception $e)
        {
            return new JsonResponse(
                ['error' => "Error while using LIFX API: {$e->getMessage()}"],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        // Hue
        try
        {
            // TODO: Automatically refresh the token when it's nearing expiry
            $appToken = AppToken::where('app', 'hue')->first();

            $client = HttpClient::create([
                'base_uri' => 'https://api.meethue.com/route/',
                'auth_bearer' => $appToken->access_token,
                'headers' => [
                    'hue-application-key' => $appToken->username
                ]
            ]);

            $lightId = Config::get('app.hue.light_id');

            $response = $client->request('PUT', "clip/v2/resource/light/{$lightId}", [
                'json' => [
                    'on' => [
                        'on' => true,
                    ],
                    'dimming' => [
                        'brightness' => 1,
                    ],
                    'dimming_delta' => [
                        'action' => 'up',
                        'brightness_delta' => 60,
                    ],
                    'dynamics' => [
                        'duration' => $fadeDuration * 1000
                    ]
                ]
            ]);

            $response->getContent();
        }
        catch (\Exception $e)
        {
            return new JsonResponse(
                ['error' => "Error while using Hue API: {$e->getMessage()}"],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            ['message' => 'Waking up'],
            Response::HTTP_OK
        );
    }
}
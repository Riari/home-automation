<?php

namespace App\Phase\Sleep;

use Adbar\Dot;
use Closure;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleSleepEvent extends Phase
{
    private HttpClientInterface $client;

    public function __construct(Closure $next, Request $request, array $params)
    {
        parent::__construct($next, $request, $params);

        $this->client = HttpClient::createForBaseUri('https://api.lifx.com/v1/', [
            'auth_bearer' => Config::Get('app.lifx.token')
        ]);
    }

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

        try
        {
            $response = $this->client->request(
                'PUT',
                'lights/group:Bedroom/state',
                [
                    'json' => [
                        'power' => 'on',
                        'duration' => Config::get('app.lights.wake_duration'),
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

        return new JsonResponse(
            ['message' => 'Waking up'],
            Response::HTTP_OK
        );
    }
}
<?php

namespace App\Action\Sleep;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Action\IAction;
use App\Config;

class Wake implements IAction
{
    private HttpClientInterface $client;

    public function __construct()
    {
        $this->client = HttpClient::createForBaseUri('https://api.lifx.com/v1/', [
            'auth_bearer' => Config::Get('app.lifx.token')
        ]);
    }

    // TODO: Replace this when middleware support is added
    private function isAuthorized(): bool
    {
        return isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] == Config::get('app.auth.basic_user')
            && isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] == Config::get('app.auth.basic_pass');
    }

    public function execute(array $params): JsonResponse
    {
        if (!$this->isAuthorized())
        {
            return new JsonResponse(
                ['error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($params['event'] != 'alarm_alert_start')
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
                        'duration' => Config::get('app.lifx.wake_duration'),
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
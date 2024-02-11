<?php

namespace App\Action\Sleep;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Config;

class Sleep implements IAction
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
        if (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], '@') !== false) {
            list($credentials, $url) = explode('@', $_SERVER['PHP_SELF'], 2);
            list($username, $password) = explode(':', $credentials);
            
            return $username == Config::get('app.auth.basic_user') && $password == Config::get('app.auth.basic_pass');
        }

        return false;
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
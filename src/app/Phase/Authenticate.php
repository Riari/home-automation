<?php

namespace App\Phase;

use Adbar\Dot;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Phase
{
    public function handle(Dot $state): Response
    {
        $username = "";
        $password = "";
        
        if (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], '@') !== false)
        {
            list($credentials, $url) = explode('@', $_SERVER['PHP_SELF'], 2);
            list($username, $password) = explode(':', $credentials);   
        }
        else if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
        {
            $username = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];
        }

        $isAuthenticated = $username == Config::get('app.auth.basic_user') && $password == Config::get('app.auth.basic_pass');

        if (!$isAuthenticated)
        {
            return new JsonResponse(
                ['error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->next($state);
    }
}
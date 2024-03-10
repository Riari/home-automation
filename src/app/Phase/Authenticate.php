<?php

namespace App\Phase;

use Adbar\Dot;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Phase
{
    public function handle(Dot $state): Response
    {
        session_start();

        if (!$_SESSION['user'])
        {
            return new JsonResponse(
                ['error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->next($state);
    }
}
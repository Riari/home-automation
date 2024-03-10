<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Util\Session as SessionUtil;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Phase\Http\Response\ViewResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowLoginForm extends Phase
{
    public function handle(Dot $state): Response
    {
        session_start();

        // TODO: Flashed messages should be injected into all view responses
        return new ViewResponse('login', [
            'flashSuccess' => SessionUtil::getFlash('success'),
            'flashError' => SessionUtil::getFlash('error')
        ]);
    }
}
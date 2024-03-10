<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Phase\Http\Response\ViewResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowLoginForm extends Phase
{
    public function handle(Dot $state): Response
    {
        return new ViewResponse('login', []);
    }
}
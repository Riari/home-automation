<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Phase\Http\Response\ViewResponse;
use Symfony\Component\HttpFoundation\Response;

class ShowDashboard extends Phase
{
    public function handle(Dot $state): Response
    {
        $clientId = Config::get('app.hue.client_id');
        $state = random_bytes(16);
        $_SESSION['hue_oauth_state'] = $state;

        return new ViewResponse('dashboard', [
            'hueClientId' => $clientId,
            'hueState' => $state,
        ]);
    }
}
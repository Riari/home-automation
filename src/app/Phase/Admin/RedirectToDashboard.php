<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class RedirectToDashboard extends Phase
{
    public function handle(Dot $state): Response
    {
        return new RedirectResponse("/admin/dashboard");
    }
}
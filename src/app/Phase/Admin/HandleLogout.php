<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Util\Session as SessionUtil;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class HandleLogout extends Phase
{
    public function handle(Dot $state): Response
    {
        session_start();
        $_SESSION['user'] = null;

        SessionUtil::setFlash("Logged out");

        return new RedirectResponse('/admin/login');
    }
}
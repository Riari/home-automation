<?php

namespace App\Phase;

use Adbar\Dot;
use App\Util\Session as SessionUtil;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Phase
{
    public function handle(Dot $state): Response
    {
        session_start();

        if (!isset($_SESSION['user']))
        {
            SessionUtil::setFlash("Authentication required", "warning");
            return new RedirectResponse("/admin/login");
        }

        return $this->next($state);
    }
}
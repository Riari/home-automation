<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Model\User;
use App\Util\Session as SessionUtil;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class HandleLoginSubmit extends Phase
{
    public function handle(Dot $state): Response
    {
        // TODO: Validate
        $payload = $_POST;

        $user = User::where('email', $payload['email'])->first();

        if (!$user || !password_verify($payload['password'], $user->password)) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }

        session_start();
        $_SESSION['user'] = $user;
        
        SessionUtil::setFlash("Logged in");

        return new RedirectResponse('/admin/dashboard');
    }
}
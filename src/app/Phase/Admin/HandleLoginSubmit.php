<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Model\User;
use App\Model\Session as SessionModel;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Phase\Http\Response\ViewResponse;
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

        return new RedirectResponse('/admin/dashboard');
    }
}
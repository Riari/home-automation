<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Model\User;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateUser extends Phase
{
    public function handle(Dot $state): Response
    {
        // TODO: Validate
        $payload = json_decode($this->request->getContent(), true);

        $email = $payload['email'];
        $password = password_hash($payload['password'], PASSWORD_DEFAULT);

        User::create([
            'email' => $email,
            'password' => $password,
        ]);

        return new JsonResponse(
            ['message' => 'Success'],
            Response::HTTP_OK
        );
    }
}
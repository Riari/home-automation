<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use Illuminate\Database\Capsule\Manager;
use Phase\Config\Config;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

// TODO: This is a temporary solution for execution migrations
class MigrateDatabase extends Phase
{
    public function handle(Dot $state): Response
    {
        Manager::schema()->create('app_tokens', function ($table) {
            $table->string('app')->primary();
            $table->text('token');
            $table->timestamps();
        });

        Manager::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->text('email');
            $table->text('password');
            $table->timestamps();
        });

        return new JsonResponse(
            ['message' => 'Success'],
            Response::HTTP_OK
        );
    }
}
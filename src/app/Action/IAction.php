<?php

namespace App\Action;

use Symfony\Component\HttpFoundation\Response;

interface IAction
{
    public function execute(array $params): Response;
}
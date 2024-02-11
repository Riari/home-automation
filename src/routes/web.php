<?php

use App\Action\Sleep;

$r->addRoute('POST', '/events/sleep', [Sleep::class, 'execute']);
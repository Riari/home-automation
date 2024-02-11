<?php

use App\Action\Sleep\Alarm;

$r->addRoute('POST', '/events/sleep/alarm', [Alarm::class, 'execute']);
<?php

use App\Phase\Authenticate;
use App\Phase\HandleSleepEvent;

$r->addRoute('POST', '/events/sleep', [Authenticate::class, HandleSleepEvent::class]);
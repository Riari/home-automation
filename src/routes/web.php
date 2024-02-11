<?php

use App\Action\Sleep\Wake;

$r->addRoute('POST', '/sleep/wake', [Wake::class, 'execute']);
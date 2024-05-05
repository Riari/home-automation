<?php

use App\Phase\Authenticate;
use App\Phase\BasicAuthenticate;
use App\Phase\Admin\CreateUser;
use App\Phase\Admin\GetHueDeviceList;
use App\Phase\Admin\HandleHueCallback;
use App\Phase\Admin\HandleLoginSubmit;
use App\Phase\Admin\HandleLogout;
use App\Phase\Admin\MigrateDatabase;
use App\Phase\Admin\RedirectToDashboard;
use App\Phase\Admin\ShowDashboard;
use App\Phase\Admin\ShowLoginForm;
use App\Phase\Sleep\HandleSleepEvent;

$r->addRoute('GET', '/admin', [RedirectToDashboard::class]);
$r->addRoute('POST', '/admin/login', [HandleLoginSubmit::class]);
$r->addRoute('GET', '/admin/login', [ShowLoginForm::class]);
$r->addRoute('GET', '/admin/logout', [HandleLogout::class]);
$r->addRoute('GET', '/admin/dashboard', [Authenticate::class, ShowDashboard::class]);
$r->addRoute('GET', '/admin/hue/callback', [Authenticate::class, HandleHueCallback::class]);
$r->addRoute('GET', '/admin/hue/devices', [Authenticate::class, GetHueDeviceList::class]);

$r->addRoute('POST', '/admin/user/create', [BasicAuthenticate::class, CreateUser::class]);
$r->addRoute('POST', '/admin/migratedb', [BasicAuthenticate::class, MigrateDatabase::class]);

$r->addRoute('POST', '/events/sleep', [BasicAuthenticate::class, HandleSleepEvent::class]);
<?php

namespace App\Phase\Admin;

use Adbar\Dot;
use App\Model\Setting;
use App\Util\Session as SessionUtil;
use Phase\Http\Phase\Phase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class EnableSleepEvents extends Phase
{
    public function handle(Dot $state): Response
    {
        $setting = Setting::firstOrNew(['key' => 'enable_sleep_events']);
        $setting->value = "1";
        $setting->save();

        SessionUtil::setFlash("Sleep events enabled");

        return new RedirectResponse('/admin/dashboard');
    }
}
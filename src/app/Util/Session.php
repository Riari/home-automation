<?php

namespace App\Util;

class Session
{
    public static function setFlash($message, $type = 'success'): void
    {
        if (!$_SESSION['flash'])
        {
            $_SESSION['flash'] = [];
        }

        $_SESSION['flash'][$type] = $message;
    }

    public static function getFlash($type): string|null
    {
        if (!$_SESSION['flash'] || !isset($_SESSION['flash'][$type]))
        {
            return null;
        }

        $message = $_SESSION['flash'][$type];

        $_SESSION['flash'][$type] = null;

        return $message;
    }
}

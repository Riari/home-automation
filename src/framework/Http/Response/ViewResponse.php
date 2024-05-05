<?php

namespace Phase\Http\Response;

use App\Util\Session as SessionUtil;
use Jenssegers\Blade\Blade;
use Symfony\Component\HttpFoundation\Response;

class ViewResponse extends Response
{
    public function __construct(string $view, array $params, int $status = 200, array $headers = [])
    {
        // TODO: Don't hardcode the paths here
        $blade = new Blade('../views', '../storage/cache/views');

        $params['flashError'] = SessionUtil::getFlash('error');
        $params['flashWarning'] = SessionUtil::getFlash('warning');
        $params['flashSuccess'] = SessionUtil::getFlash('success');

        parent::__construct($blade->make($view, $params)->render(), $status, $headers);
    }
}
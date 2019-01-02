<?php

namespace App\Helpers;

use Illuminate\Support\Facades\URL;

class Helper
{
    public static function formAction($path)
    {
        return URL::to($path, array(), (env('HTTPS_ENABLE') == 'true') ? true : false);
    }
}

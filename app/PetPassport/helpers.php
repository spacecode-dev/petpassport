<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;

if (!function_exists('body_class')) {
    function body_class()
    {
        $request = Request::path();
        $class = '';
        if($request !== '/' && $request === 'login' || $request === 'register') {
            $class = explode('/', $request)[sizeof(explode('/', $request)) - 1];
            $class = Str::slug($class, '-');
        }
        return $class;
    }
}
<?php

namespace App\PetPassport;

use Illuminate\Support\Facades\Route;

class PetPassport
{
    /**
     * @return string
     */
    public static function apiPath()
    {
        return config('petpassport.apiPath');
    }

    /**
     * @return PendingRouteRegistration
     */
    public static function routes()
    {
//        Route::aliasMiddleware('petpassport');
        return new PendingRouteRegistration;
    }
}

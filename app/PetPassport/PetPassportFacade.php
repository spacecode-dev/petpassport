<?php

namespace App\PetPassport;

use Illuminate\Support\Facades\Facade;

class PetPassportFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'petpassport';
    }
}

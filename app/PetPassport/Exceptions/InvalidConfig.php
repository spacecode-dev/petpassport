<?php

namespace App\PetPassport\Exceptions;

use Exception;

class InvalidConfig extends Exception
{
    /**
     * @return static
     */
    public static function driverNotSupported()
    {
        return new static('Драйвер не поддерживается. Проверьте свои настройки конфигурации');
    }
}

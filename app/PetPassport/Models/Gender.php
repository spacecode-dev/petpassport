<?php

namespace App\PetPassport\Models;

use Illuminate\Support\Collection;

class Gender
{
    public const LIST = [
        1 => 'male',
        2 => 'female'
    ];

    /**
     * @return Collection
     */
    public static function getWithTranslate()
    {
        $genders = collect(self::LIST);
        return $genders->transform(function ($item, $key) {
            $item = trans('messages.' . $item);
            return $item;
        });
    }
}

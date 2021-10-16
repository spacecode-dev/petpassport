<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * @var string
     */
    protected $table = 'currencies';

    /**
     * @return mixed
     */
    public function scopeGetWithTranslate()
    {
        $currencies =  $this->get();
        return $currencies->transform(function ($item, $key) {
            $item->name = trans('currencies.plural.' . $item->name);
            return $item;
        });
    }
}

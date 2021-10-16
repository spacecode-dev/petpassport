<?php

namespace App\PetPassport\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserType extends Model
{
    /**
     * @var string
     */
    protected $table = 'user_types';

    /**
     * @return UserType[]|\Illuminate\Database\Eloquent\Collection|Collection
     */
    public function getWithTranslate()
    {
        return $this->all()->map(function ($item, $key) {
            $item->name = trans('user_type.' . $item->name);
            return $item;
        });
    }
}

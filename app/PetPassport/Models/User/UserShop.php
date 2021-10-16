<?php

namespace App\PetPassport\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShop extends Model
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;
}

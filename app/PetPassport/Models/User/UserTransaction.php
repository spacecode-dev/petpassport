<?php

namespace App\PetPassport\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];
}

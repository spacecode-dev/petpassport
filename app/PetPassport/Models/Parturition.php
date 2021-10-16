<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;

class Parturition extends Model
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'heat_date',
        'pairing_date',
        'parturition_date',
        'litter'
    ];
}

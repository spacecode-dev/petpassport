<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'type',
        'date',
        'drug',
        'batch',
        'dose',
        'doctor',
        'comments'
    ];
}

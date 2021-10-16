<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    /**
     * @var string
     */
    public $primaryKey = 'user_id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'chip_number',
        'localization',
        'chip_date',
        'certificate',
        'dnk',
        'reg_number',
        'reg_clinic',
        'reg_journal_number',
        'reg_date',
        'reg_vet_name',
        'breed',
        'colour',
        'dist_marks',
        'animal_card_number',
        'pedigree_number',
        'tag_number'
    ];
}

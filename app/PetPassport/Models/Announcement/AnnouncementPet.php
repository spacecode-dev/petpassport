<?php

namespace App\PetPassport\Models\Announcement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnouncementPet extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'pet_id',
        'gender',
        'birthday',
        'vetpassport',
        'pedigree',
        'contract',
        'vaccination',
        'mark',
        'chip'
    ];
}

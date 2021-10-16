<?php

namespace App\PetPassport\Models\Community;

use Illuminate\Database\Eloquent\Model;

class CommunityProfileBreed extends Model
{

    /**
     * @var string
     */
    public $primaryKey = 'community_id';

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
        'history',
        'standard',
        'terminology'
    ];
}

<?php

namespace App\PetPassport\Models\Community;

use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityProfileNursery extends Model
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
        'certificate',
        'owner_id',
        'address',
        'phone',
        'email',
        'site'
    ];

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(UserProfile::class, 'owner_id', 'user_id');
    }
}

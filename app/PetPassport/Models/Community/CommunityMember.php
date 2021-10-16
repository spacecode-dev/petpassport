<?php

namespace App\PetPassport\Models\Community;

use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityMember extends Model
{

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'community_id',
        'user_id'
    ];

    /**
     * @return BelongsTo
     */
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->hasMany(self::class, 'community_id', 'community_id');
        /*
        return $this->hasManyThrough(
            'App\Models\UserProfile',
            'App\Models\CommunityMember',
            'community_id',
            'user_id',
            'community_id',
            'user_id'
        );
        */
    }
}

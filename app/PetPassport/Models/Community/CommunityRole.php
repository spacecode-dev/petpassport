<?php

namespace App\PetPassport\Models\Community;

use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityRole extends Model
{

    /**
     * @var bool
     */
    public $incrementing = false;

    public const ROLES = [
        1 => 'owner',
        2 => 'admin',
        3 => 'moder',
        'owner' => 1,
        'admin' => 2,
        'moder' => 3
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'community_id',
        'user_id',
        'role'
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
    public function profile()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }
}

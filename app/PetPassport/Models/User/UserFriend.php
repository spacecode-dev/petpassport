<?php

namespace App\PetPassport\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFriend extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $casts = [
        'accepted' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'accepted' => false,
    ];

    /**
     * @return BelongsTo
     */
    public function side1()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function side2()
    {
        return $this->belongsTo(UserProfile::class, 'friend_id', 'user_id');
    }

//    /**
//     * @return BelongsTo
//     */
//    public function profiles()
//    {
//        return $this->belongsTo(UserProfile::class, ['user_id', 'friend_id'], 'user_id');
//    }
}

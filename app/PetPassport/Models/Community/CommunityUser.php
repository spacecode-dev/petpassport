<?php

namespace App\PetPassport\Models\Community;

use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityUser extends Model
{

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }
}

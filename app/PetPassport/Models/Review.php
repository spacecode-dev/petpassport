<?php

namespace App\PetPassport\Models;

use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'owner_type',
        'body',
        'stars'
    ];

    /**
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
         return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }
}

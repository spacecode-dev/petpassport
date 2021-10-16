<?php

namespace App\PetPassport\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscription extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wall_id',
        'wall_type'
    ];

    /**
     * @return BelongsTo
     */
    public function subscriber()
    {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }

    /**
     * @return MorphTo
     */
    public function wall()
    {
        return $this->morphTo();
    }
}

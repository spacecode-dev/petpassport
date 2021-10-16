<?php

namespace App\PetPassport\Models;

use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'object_id',
        'object_type',
        'user_id'
    ];

    /**
     * @return MorphTo
     */
    public function object()
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

    /**
     * @return HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class, [ 'object_id', 'object_type' ], [ 'object_id', 'object_type' ]);
    }
}

<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'object_id',
        'object_type'
    ];

    /**
     * @return MorphTo
     */
    public function object()
    {
        return $this->morphTo();
    }

    /**
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }
}

<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PostAttachment extends Model
{
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
        'post_id',
        'attachment_id',
        'attachment_type'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'post_id',
        'attachment_id'
    ];

    /**
     * @return MorphTo
     */
    public function attachment()
    {
        return $this->morphTo();
    }
}

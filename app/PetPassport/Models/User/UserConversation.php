<?php

namespace App\PetPassport\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserConversation extends Model
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'recipient_id',
        'recipient_type'
    ];

    /**
     * @return MorphTo
     */
    public function recipient()
    {
        return $this->morphTo();
    }
}

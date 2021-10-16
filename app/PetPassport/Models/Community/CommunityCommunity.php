<?php

namespace App\PetPassport\Models\Community;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityCommunity extends Model
{

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function linked()
    {
        return $this->belongsTo(Community::class, 'linked_id');
    }
}

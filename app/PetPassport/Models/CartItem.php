<?php

namespace App\PetPassport\Models;

use App\PetPassport\Models\Announcement\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'announcement_id',
        'count'
    ];

    /**
     * @return BelongsTo
     */
    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}

<?php

namespace App\PetPassport\Models\Announcement;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnouncementPhoto extends Model
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;
}

<?php

namespace App\PetPassport\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoAlbum extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $morphClass = 'video_album';

    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'owner_type',
        'name',
        'description'
    ];

    /**
     * @return HasMany
     */
    public function videos()
    {
        return $this->hasMany(Video::class, 'album_id');
    }

    /**
     * @return HasOne
     */
    public function cover()
    {
        return $this->hasOne(Video::class, 'album_id')
            ->orderBy('id', 'desc');
    }
}

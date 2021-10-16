<?php

namespace App\PetPassport\Models\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PhotoAlbum extends Model
{

    /**
     * @var string
     */
    protected $morphClass = 'photo_album';

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
    public function photos()
    {
        return $this->hasMany(Photo::class, 'album_id');
    }

    /**
     * @return HasOne
     */
    public function cover()
    {
        return $this->hasOne(Photo::class, 'album_id')
            ->orderBy('id', 'desc');
    }
}

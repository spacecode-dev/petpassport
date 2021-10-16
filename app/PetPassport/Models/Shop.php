<?php

namespace App\PetPassport\Models;

use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\User\UserShop;
use Illuminate\Database\Eloquent\Model;
use App\PetPassport\Models\Media\Photo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Shop extends Model
{
    /**
     * @var string
     */
    protected $morphClass = 'shop';

    /**
     * @var array
     */
    protected $fillable = [
    	'type',
    	'category_id',
    	'name',
    	'phone',
    	'email',
    	'logo',
    	'banner',
    	'sign',
    	'description'
    ];

    /**
     * @var array
     */
    public $appends = [
        'link',
        'avatar'
    ];

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        $slugId = $this->slug ?: $this->id;
        return "/market/shops/{$slugId}}";
    }

    /**
     * @return mixed
     */
    public function getLogoAttribute()
    {
        return $this->avatar;
    }

    /**
     * @return MorphMany
     */
    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'owner');
    }

    /**
     * @return mixed
     */
    public function getStarsAttribute()
    {
        return $this->reviews()->avg('stars');
    }

    /**
     * @return MorphMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'owner');
    }

    /**
     * @return MorphMany
     */
    public function photos_all()
    {
        return $this->morphMany(Photo::class, 'owner');
    }

    /**
     * @return MorphMany
     */
    public function photos()
    {
        return $this->photos_all()
            ->where('section', Photo::SECTIONS['photo']);
    }

    /**
     * @return MorphMany
     */
    public function avatars()
    {
        return $this->photos_all()
            ->where('section', Photo::SECTIONS['avatar']);
    }

    /**
     * @return MorphOne
     */
    public function avatar_raw()
    {
        return $this->morphOne(Photo::class, 'owner')
            ->where('section', Photo::SECTIONS['avatar'])
            ->orderBy('id', 'desc');
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        //return '/img/other/logo.png';
        return $this->avatar_raw ? $this->avatar_raw->getAttribute('original') : '/img/avatar-300.png';
    }

    /**
     * @return MorphMany
     */
    public function covers()
    {
        return $this->photos_all()->where('section', Photo::SECTIONS['cover']);
    }

    /**
     * @return MorphOne
     */
    public function cover_raw()
    {
        return $this->morphOne(Photo::class, 'owner')->where('section', Photo::SECTIONS['cover'])->orderBy('id', 'desc');
    }

    /**
     * @return mixed
     */
    public function getCoverAttribute()
    {
        return $this->cover_raw ? $this->cover_raw->getAttribute('original') : null;
    }

    /**
     * @return HasMany
     */
    public function ownerships()
    {
        return $this->hasMany(UserShop::class);
    }

    /**
     * @return bool
     */
    public function getOwnedAttribute()
    {
        $user_id = auth('api')->id();
        if (!$user_id) return false;
        return $this->ownerships()->where('user_id', $user_id)->exists();
    }
}

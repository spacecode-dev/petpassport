<?php

namespace App\PetPassport\Models\Media;

use App\PetPassport\Models\Comment;
use App\PetPassport\Models\Like;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\PetPassport\Collections\PhotoCollection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property $section 1 = Photos, 2 = Avatar, 3 = Profile cover, 4 = Wall, 5 = Market
 */
class Photo extends Model
{
    use SoftDeletes;

    public const SECTIONS = [
        1 => 'photo',
        2 => 'avatar',
        3 => 'cover',
        4 => 'wall',
        5 => 'market',
        'photo'  => 1,
        'avatar' => 2,
        'cover'  => 3,
        'wall'   => 4,
        'market' => 5
    ];

    public const THUMB_SIZES = [
        180,
        360,
        720,
        1440,
        2880
    ];

    /**
     * @var string
     */
    protected $morphClass = 'photo';

    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'owner_type',
        'section',
        'description',
        'album_id'
    ];

    /**
     * @var array
     */
    public $appends = [
        'srcset',
        'thumb_180',
        'thumb_360',
        'thumb_720',
        'thumb_1440',
        'thumb_2880',
        'thumb_largest',
        'liked'
    ];

    /**
     * @var array
     */
    protected $withCount = [
        'likes',
        'comments'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('likes_user_count', function (Builder $builder) {
            $builder->withCount('likes_user');
        });
    }

    /**
     * @param  array  $models
     * @return Collection
     */
    public function newCollection(array $models = [])
    {
        return new PhotoCollection($models);
    }

    /**
     * @return MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }

    /**
     * @return MorphMany
     */
    public function likes_user()
    {
        return $this->likes()
            ->where('user_id', auth('api')->id());
    }

    /**
     * @return bool
     */
    public function getLikedAttribute()
    {
        return $this->likes_user_count > 0;
    }

    /**
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'object');
    }

    /**
     * @return string
     */
    public function getSrcsetAttribute()
    {
        $sources = [];
        foreach (self::THUMB_SIZES as $size) {
            $thumb = $this->getOriginal('thumb_' . $size);
            if ($thumb) {
                $sources[] = "{$thumb} {$size}w";
            }
        }
        $sources[] = "{$this->getAttribute('original')} {$this->original_width}w";
        return implode(',', $sources);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getThumb180Attribute($value)
    {
        return $value ?? $this->getAttribute('thumb_180');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getThumb360Attribute($value)
    {
        return $value ?? $this->getAttribute('thumb_360');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getThumb720Attribute($value)
    {
        return $value ?? $this->getAttribute('thumb_720');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getThumb1440Attribute($value)
    {
        return $value ?? $this->getAttribute('thumb_1440');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getThumb2880Attribute($value)
    {
        return $value ?? $this->getAttribute('thumb_2880');
    }

    /**
     * @return array|mixed
     */
    public function getThumbLargestAttribute()
    {
        $source = $this->getAttribute('original');
        foreach (self::THUMB_SIZES as $size) {
            $thumb = $this->getOriginal('thumb_' . $size);
            if ($thumb)
                $source = $thumb;
        }
        return $source;
    }

    /**
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }
}

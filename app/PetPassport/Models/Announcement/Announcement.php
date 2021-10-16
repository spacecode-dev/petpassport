<?php

namespace App\PetPassport\Models\Announcement;

use App\PetPassport\Models\CartItem;
use App\PetPassport\Models\Like;
use App\PetPassport\Models\MarketCategory;
use App\PetPassport\Models\Media\Photo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\PetPassport\Models\User\UserShop;

class Announcement extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'announcements';

    /**
     * @return array
     */
    public function searchableOptions()
    {
        return [
            'column' => 'searchable',
            'external' => true,
            'maintain_index' => true,
            'rank' => [
                'fields' => [
                    'title' => 'A',
                    'description' => 'B'
                ],
                'function' => 'ts_rank',
                'normalization' => 32,
            ],
        ];
    }

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description
        ];
    }

    /**
     * @var array
     */
    public $fillable = [
        'from',
        'type',
        'category_id',
        'country_id',
        'city_id',
        'title',
        'description',
        'price',
        'currency',
        'bargain'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'colored_until',
        'pinned_until'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'colored',
        'pinned',
        'liked',
        'owned',
        'in_cart'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'likes_user_count',
        'cart_item',
        'searchable'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('likes_user_count', function (Builder $builder) {
            $builder->withCount('likes_user');
        });
        static::addGlobalScope('cart_item', function (Builder $builder) {
            $builder->with('cart_item');
        });
    }

    /**
     * @return bool
     */
    public function getColoredAttribute()
    {
        return $this->colored_until && $this->colored_until > now();
    }

    /**
     * @return bool
     */
    public function getPinnedAttribute()
    {
        return $this->pinned_until && $this->pinned_until > now();
    }

    /**
     * @return bool
     */
    public function getLikedAttribute()
    {
        return $this->likes_user_count > 0;
    }

    /**
     * @return bool
     */
    public function getOwnedAttribute()
    {
        $user_id = auth('api')->id();
        return $this->owner_id === $user_id && $this->owner_type === 'profile';
    }

    /**
     * @return bool
     */
    public function getCanEditAttribute()
    {
        $user_id = auth('api')->id();
        if ($this->owner_type === 'profile') {
            return $this->owner_id === $user_id;
        }
        if ($this->owner_type === 'shop') {
            return UserShop::where('shop_id', $this->owner_id)
                ->where('user_id', $user_id)
                ->exists();
        }
    }

    /**
     * @return HasOne
     */
    public function announcement_pet()
    {
        return $this->hasOne(AnnouncementPet::class);
    }

//    /**
//     * @return HasOne
//     */
//    public function creator()
//    {
//        return $this->hasOne(UserProfile::class, 'user_id', 'user_id');
//    }

    /**
     * @return HasManyThrough
     */
    public function photos()
    {
        return $this->hasManyThrough(
            Photo::class,
            AnnouncementPhoto::class,
            'announcement_id',
            'id',
            'id',
            'photo_id'
        );
    }

    /**
     * @return HasOneThrough
     */
    public function photo()
    {
        return $this->hasOneThrough(
            Photo::class,
            AnnouncementPhoto::class,
            'announcement_id',
            'id',
            'id',
            'photo_id'
        );
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
        $user_id = auth('api')->id();

        return $this->likes()
            ->where('user_id', $user_id);
    }

    /**
     * @return MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(MarketCategory::class, 'category_id');
    }

    /**
     * @return mixed
     */
    public function getParentCategoryIdAttribute()
    {
        if ($this->category_id) {
            return $this->category->parent_id;
        }
    }

    /**
     * @return HasOne
     */
    public function cart_item()
    {
        $user_id = auth('api')->id();
        return $this->hasOne(CartItem::class)
            ->where('user_id', $user_id);
    }

    /**
     * @return bool
     */
    public function getInCartAttribute()
    {
        return $this->cart_item ? true : false;
    }

    /**
     * @param $childType
     * @param $value
     * @param $field
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}

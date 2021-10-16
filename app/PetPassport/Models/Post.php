<?php

namespace App\PetPassport\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\PetPassport\Collections\PostCollection;
use App\PetPassport\Models\User\UserFriend;
use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\Media\Photo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'posts';

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
                    'body' => 'A'
                ],
                'weights' => [1.0],
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
            'body' => $this->body,
        ];
    }

    public const TYPES = [
        1 => 'post',
        2 => 'avatar',
        3 => 'cover',
        'post'   => 1,
        'avatar' => 2,
        'cover'  => 3
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'searchable'
    ];

    /**
     * @var array
     */
    public $fillable = [
        'type',
        'wall_id',
        'wall_type',
        'owner_id',
        'owner_type',
        'origin_id',
        'origin_type',
        'body',
        'privacy',
        'sos'
    ];

    /**
     * @var array
     */
    protected $visible = [
        'id',
        'type',
        'owner_id',
        'owner_type',
        'body',
        'privacy',
        'sos',
        'created_at',
        // Counters:
        'likes_count',
        'reposts_count',
        'comments_count',
        // Relations:
        'owner',
        'origin',
        'attachments',
        // Attached by collection:
        'liked',
        'reposted'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'sos' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'sos' => false,
        'type' => 1
    ];

//    /**
//     * @var array
//     */
//    public $appends = [
//        'owner'
//    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('attachments', function (Builder $builder) {
            $builder->with([
                'attachments.attachment' => function (MorphTo $morphTo) {
                    $morphTo->morphWith([
                        Announcement::class => [
                            'photo'
                        ],
                        Photo::class => [
                            'owner'
                        ]
                    ]);
                }
            ]);
        });
        static::addGlobalScope('owner', function (Builder $builder) {
            $builder->with([
                'owner'
                /* => function (MorphTo $morphTo) {
                    dd ($morphTo->getDictionary());
                }
                */
            ]);
        });
        static::addGlobalScope('origin', function (Builder $builder) {
            $builder->with([
                'origin.owner'
            ]);
        });
    }

    /**
     * @param $query
     */
    public function scopeWithCounters($query)
    {
        $query->withCount([
            'likes',
            'reposts',
            'comments'
        ]);
    }

    /**
     * @param array $models
     * @return PostCollection|Collection
     */
    public function newCollection(array $models = [])
    {
        return new PostCollection($models);
    }

    /**
     * @return MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }

    /**
     * @return HasMany
     */
    public function reposts()
    {
        return $this->hasMany(self::class, 'origin_id');
    }

    /**
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'object');
    }

    /**
     * @param $query
     * @param null $user_id
     */
    public function scopePrivacyCheck($query, $user_id = null)
    {
        $user_id = auth('api')->id();
        $ids = [];
        if ($user_id) {
            $friendships = UserFriend::where(function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
                $query->orWhere('friend_id', $user_id);
            })
            ->where('accepted', true)
            ->get();
            $ids1 = $friendships->pluck('user_id');
            $ids2 = $friendships->pluck('friend_id');
            //$ids = array_diff($ids1->merge($ids2)->toArray(), [ $user_id ]);
            $ids = $ids1->merge($ids2)->toArray();
            $ids[] = $user_id;
        }
        $query->where(function($query) use ($ids, $user_id) {
            $query->where('privacy', null);
            $query->orWhere('privacy', 0);
            if (count($ids)) {
                $query->orWhere(function($query) use ($ids) {
                    $query->where('privacy', 1);
                    $query->where('owner_type', 'profile');
                    $query->whereIn('owner_id', $ids);
                });
            }
            if ($user_id) {
                $query->orWhere(function($query) use ($user_id) {
                    $query->where('privacy', 2);
                    $query->where('owner_type', 'profile');
                    $query->where('owner_id', $user_id);
                });
            }
        });
    }

    /**
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(PostAttachment::class);
    }

    /**
     * @return MorphToMany
     */
    public function photos()
    {
        return $this->morphedByMany(
            Photo::class,
            'attachment',
            'post_attachments'
        );
    }

    /**
     * @return MorphToMany
     */
    public function announcements()
    {
        return $this->morphedByMany(
            Announcement::class,
            'attachment',
            'post_attachments'
        );
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
    public function origin()
    {
        return $this->belongsTo(self::class, 'origin_id');
    }

//    /**
//     * @param $value
//     * @return mixed
//     */
//    public function getOwnerAttribute($value)
//    {
//        if ($value) {
//            dd('owner');
//            if ($this->owner_type === 'community') {
//                dd('community ' . $value->id);
//            }
//            if ($this->owner_type === 'profile') {
//                dd('profile ' . $value->user_id);
//            }
//        }
//        return $value;
//    }

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

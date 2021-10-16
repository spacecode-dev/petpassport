<?php

namespace App\PetPassport\Models\Community;

use App\PetPassport\Models\Like;
use App\PetPassport\Models\PetProfile;
use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\PetPassport\Models\Media\Photo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $table = 'communities';

    /**
     * @var string
     */
    protected $morphClass = 'community';

    /**
     * @var array
     */
    public $fillable = [
        'type',
        'name',
        'slug'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'link',
        'avatar'
    ];

    /**
     * @var array
     */
    protected $with = [
        'avatar_raw'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'avatar_raw',
        'searchable'
    ];

    public const RESERVED_SLUGS = [
        //
    ];

    public const TYPES = [
        1 => 'groups',
        2 => 'nurseries',
        3 => 'pages',
        4 => 'breeds',
        'groups' => 1,
        'nurseries' => 2,
        'pages' => 3,
        'breeds' => 4
    ];

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
                    'name' => 'A'
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
            'name' => $this->name,
        ];
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        $types = self::TYPES[$this->type];
        $slugId = ($this->slug ?: $this->id);
        return "/{$types}/{$slugId}";
    }

    /**
     * @return HasMany
     */
    public function memberships()
    {
        return $this->hasMany(CommunityMember::class);
    }

    /**
     * @return HasManyThrough
     */
    public function members()
    {
        return $this->hasManyThrough(
            UserProfile::class,
            CommunityMember::class,
            'community_id',
            'user_id',
            'id',
            'user_id'
        );
    }

    /**
     * @return Collection
     */
    public function getTopMembersAttribute()
    {
        $members = $this->members()
            ->limit(10)
            ->get();
        $members->each(function ($member) {
            $member->setVisible([
                'user_id',
                'name',
                'link',
                'avatar'
            ]);
        });
        return $members;
    }

    /**
     * @return MorphMany
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'object');
    }

    /**
     * @return HasManyThrough
     */
    public function likers()
    {
        return $this->hasManyThrough(
            UserProfile::class,
            Like::class,
            'object_id',
            'user_id',
            'id',
            'user_id'
        )->where('object_type', array_search(static::class, Relation::morphMap()) ?: static::class);
    }

    /**
     * @return Collection
     */
    public function getTopLikersAttribute()
    {
        $likers = $this->likers()
            ->limit(10)
            ->get();
        $likers->each(function ($liker) {
            $liker->setVisible([
                'user_id',
                'name',
                'link',
                'avatar'
            ]);
        });
        return $likers;
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
            ->where('section', 1);
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
        return $this->avatar_raw ? $this->avatar_raw->getAttribute('original') : '/custom/avatar-300.png';
    }

    /**
     * @return MorphMany
     */
    public function covers()
    {
        return $this->photos_all()
            ->where('section', Photo::SECTIONS['cover']);
    }

    /**
     * @return MorphOne
     */
    public function cover_raw()
    {
        return $this->morphOne(Photo::class, 'owner')
            ->where('section', Photo::SECTIONS['cover'])
            ->orderBy('id', 'desc');
    }

    /**
     * @return mixed
     */
    public function getCoverAttribute()
    {
        return $this->cover_raw ? $this->cover_raw->getAttribute('original') : null;
    }

    /**
     * @return Collection
     */
    public function getTopPhotosAttribute()
    {
        return $this->photos()
//        ->select([
//            'id',
//            'thumb_180',
//        ])
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();
    }

    /**
     * @return HasMany
     */
    public function roles()
    {
        return $this->hasMany(CommunityRole::class);
    }

    /**
     * @return mixed|null
     */
    public function getUserRoleAttribute()
    {
        $user_id = auth('api')->id();
        if ($user_id) {
            $role = $this->roles()
                ->where('user_id', $user_id)
                ->first();
            if ($role) {
                return $role->role;
            }
        }
        return null;
    }

    /**
     * @return HasOne
     */
    public function profile_nursery()
    {
        return $this->hasOne(CommunityProfileNursery::class);
    }

    /**
     * @return HasOne
     */
    public function profile_breed()
    {
        return $this->hasOne(CommunityProfileBreed::class);
    }

    /**
     * @return HasManyThrough
     */
    public function linked_communities()
    {
        return $this->hasManyThrough(
            self::class,
            CommunityCommunity::class,
            'community_id',
            'id',
            'id',
            'linked_id'
        )->withCount([
            'members',
            'likes'
        ]);
    }

    /**
     * @return HasMany
     */
    public function linked_users()
    {
        return $this->hasMany(CommunityUser::class);
        /*
        return $this->hasManyThrough(
            'App\Models\UserProfile',
            'App\Models\CommunityUser',
            'community_id',
            'user_id',
            'id',
            'user_id'
        );
        */
    }

    /**
     * @return HasManyThrough
     */
    public function pets()
    {
        //return $this->hasMany('App\Models\UserProfile', 'nursery_id');
        return $this->hasManyThrough(
            UserProfile::class,
            PetProfile::class,
            'nursery_id',
            'user_id',
            'id',
            'user_id'
        );
    }

    /**
     * @return Collection
     */
    public function getTopPetsAttribute()
    {
        $pets = $this->pets()
            ->limit(10)
            ->get();
        $pets->each(function ($pet) {
            $pet->setVisible([
                'user_id',
                'name',
                'link',
                'avatar',
                'gender'
            ]);
        });
        return $pets;
    }

    /**
     * @return HasManyThrough
     */
    public function graduates()
    {
        //return $this->hasMany('App\Models\UserProfile', 'born_nursery_id');
        return $this->hasManyThrough(
            UserProfile::class,
            PetProfile::class,
            'born_nursery_id',
            'user_id',
            'id',
            'user_id'
        );
    }

    /**
     * @return Collection
     */
    public function getTopGraduatesAttribute()
    {
        $pets = $this->graduates()
            ->limit(10)
            ->get();
        $pets->each(function ($pet) {
            $pet->setVisible([
                'user_id',
                'name',
                'link',
                'avatar',
                'gender'
            ]);
        });
        return $pets;
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

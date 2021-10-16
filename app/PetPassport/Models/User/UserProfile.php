<?php

namespace App\PetPassport\Models\User;

use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\Drug;
use App\PetPassport\Models\Parturition;
use App\PetPassport\Models\Passport;
use App\PetPassport\Models\PetProfile;
use App\PetPassport\Models\Review;
use App\PetPassport\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\PetPassport\Models\Media\Photo;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Community\CommunityMember;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UserProfile extends Model
{
    /**
     * @var string
     */
    public $primaryKey = 'user_id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $morphClass = 'profile';

    /**
     * @var string
     */
    public $table = 'user_profiles';

    /**
     * @var null
     */
    private $friend_ids = null;

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
                    'login' => 'A',
                    'name' => 'A',
                    'about' => 'B',
                    'site' => 'C',
                    'work_name' => 'C',
                    'work_place' => 'C',
                    'edu_name' => 'C',
                    'edu_group' => 'C',
                    'edu_degree' => 'C',
                ],
                'weights' => [1.0],
                'function' => 'ts_rank_cd',
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
            'login' => $this->slug,
            'name' => $this->name,
            'about' => $this->about,
            'site' => $this->site,
            'work_name' => $this->work_name,
            'work_place' => $this->work_place,
            'edu_name' => $this->edu_name,
            'edu_group' => $this->edu_group,
            'edu_degree' => $this->edu_degree,
        ];
    }

    /**
     * @var array
     */
    public $fillable = [
        'type',
        'slug',
        'name',
        'gender',
        'birthday',
        'marital_status',
        'about',
        'site',
        'phone',
        'mating',
        'memory',
        'noavatar',
        'country_id',
        'city_id',
        'birth_country_id',
        'work_name',
        'work_place',
        'edu_name',
        'edu_group',
        'edu_degree'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'mating' => 'boolean',
        'memory' => 'boolean',
        'noavatar' => 'boolean'
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
        'avatar_raw'
    ];

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        $link = $this->slug ?: $this->user_id;
        return "/{$link}";
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne
     */
    public function pet_profile()
    {
        return $this->hasOne(PetProfile::class, 'user_id', 'user_id');
    }

    /**
     * @return array
     */
    public function getMergedProfileAttribute()
    {
        if ($this->type == 3) {
            return collect($this)
                ->merge($this->pet_profile)
                ->toArray();
        }
        return $this->toArray();
    }

    /**
     * @return mixed
     */
    public function getStarsAttribute()
    {
        return $this->reviews()
            ->avg('stars');
    }

    /**
     * @return mixed
     */
    public function getTopFriendsAttribute()
    {
        $profile = $this;
        $friendships = UserFriend::where(function ($query) use ($profile) {
            $query->where('user_id', $profile->user_id);
            $query->orWhere('friend_id', $profile->user_id);
        })->where('accepted', true)
            ->limit(9);
        $ids1 = $friendships->pluck('user_id');
        $ids2 = $friendships->pluck('friend_id');
        $ids = array_diff($ids1->merge($ids2)->toArray(), [$profile->user_id]);
        return self::select([
            'user_id',
            'slug',
            'name',
            //'avatar'
        ])->whereIn('user_id', $ids)
            ->get();
    }

    /**
     * @return HasManyThrough
     */
    public function pets()
    {
        return $this->hasManyThrough(UserProfile::class, UserPet::class, 'user_id', 'user_id', 'user_id', 'pet_id');
    }

    /**
     * @return HasManyThrough
     */
    public function pet_profiles()
    {
        return $this->hasManyThrough(PetProfile::class, UserPet::class, 'user_id', 'user_id', 'user_id', 'pet_id');
    }

    /**
     * @return HasManyThrough
     */
    public function parents()
    {
        return $this->hasManyThrough(UserProfile::class, UserParent::class, 'user_id', 'user_id', 'user_id', 'parent_id')
            ->select([
                'user_profiles.user_id',
                'name',
                'slug',
                'gender',
                'birthday',
                'mating',
                'memory',
                'country_id',
                'city_id',
                'birth_country_id'
            ]);
    }

    /**
     * @return HasManyThrough
     */
    public function childrens()
    {
        return $this->hasManyThrough(UserProfile::class, UserParent::class, 'parent_id', 'user_id', 'user_id', 'user_id')
            ->select([
                'user_profiles.user_id',
                'name',
                'slug',
                'gender',
                'birthday',
                'mating',
                'memory',
                'country_id',
                'city_id',
                'birth_country_id'
            ]);
    }

    /**
     * @return HasManyThrough
     */
    public function shops()
    {
        return $this->hasManyThrough(Shop::class, UserShop::class, 'user_id', 'id', 'user_id', 'shop_id');
    }

    /**
     * @return array|Collection
     */
    public function getTopShopsAttribute()
    {
        if ($this->type === 3) return [];
        return $this->shops()
            ->select(['id', 'name'])
            ->withCount([
                'announcements' => function ($query) {
                    $query->withoutGlobalScopes();
                }
            ])
            ->limit(3)
            ->get();
    }

    /**
     * @return MorphMany
     */
    public function announcements()
    {
        return $this->morphMany(Announcement::class, 'owner');
    }

    /**
     * @return array|Collection
     */
    public function getTopAnnouncementsAttribute()
    {
        if ($this->type === 3) return [];
        return $this->announcements()
            ->select(['id', 'title', 'price', 'currency'])
            ->with('photo')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();
    }

    /**
     * @return MorphMany
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'owner');
    }

    /**
     * @return array|Collection
     */
    public function getTopReviewsAttribute()
    {
        if ($this->type === 3) return [];
        return $this->reviews()
            ->select(['id', 'user_id', 'stars', 'body', 'created_at'])
            ->with('user:user_id,name,slug')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getTopPagesAttribute()
    {
        $user_id = $this->user_id;
        return Community::select(['id', 'type', 'slug', 'name'])
            ->withCount('likes')
            ->whereIn('type', [3, 4])
            ->whereHas('likes', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->limit(3)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getTopGroupsAttribute()
    {
        $user_id = $this->user_id;
        return Community::select(['id', 'type', 'slug', 'name'])
            ->withCount('members')
            ->where('type', 1)
            ->whereHas('memberships', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->limit(3)
            ->get();
    }

    /**
     * @return mixed
     */
    public function getTopNurseriesAttribute()
    {
        $user_id = $this->user_id;
        return Community::select(['id', 'type', 'slug', 'name'])
            ->withCount('members')
            ->where('type', 2)
            ->whereHas('memberships', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->limit(3)
            ->get();
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
     * @return string|null
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
//            ->select(['id', 'thumb_180'])
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();
    }

    private function loadFriendIds()
    {
        if ($this->friend_ids !== null) return;
        $user_id = $this->user_id;
        $friendships = UserFriend::where(function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
            $query->orWhere('friend_id', $user_id);
        })->where('accepted', true)
            ->get();
        $ids1 = $friendships->pluck('user_id');
        $ids2 = $friendships->pluck('friend_id');
        $this->friend_ids = array_diff($ids1->merge($ids2)->toArray(), [$user_id]);
    }

    /**
     * @return array
     */
    public function getRecommendedProfilesAttribute()
    {
        return [];
        $this->loadFriendIds();
        if (!count($this->friend_ids)) return [];
        $user_id = $this->user_id;
        $friend_ids = $this->friend_ids;
        $query = UserFriend::query();
        $query->selectRaw('COUNT(user_id) as user_id_count, COUNT(friend_id) as friend_id_count, user_id, friend_id');
        $query->where('user_id', '!=', $user_id);
        $query->where('friend_id', '!=', $user_id);
        $query->where(function ($query) use ($friend_ids) {
            $query->whereIn('user_id', $friend_ids);
            $query->orWhereIn('friend_id', $friend_ids);
        });
        $query->groupBy('user_id');
        $query->groupBy('friend_id');
        dd($query->get()->toArray());

//        $query->whereExists(function($query) {
//            $query->select(\DB::raw(1));
//            $query->from('user_friends');
//            $query->where(function($query) {
//                $query->whereRaw('user_friends.user_id = user_profiles.user_id');
//                $query->orWhereRaw('user_friends.friend_id = user_profiles.user_id');
//            });
//        });
    }

    /**
     * @return Builder[]|Collection
     */
    public function getRecommendedGroupsAttribute()
    {
        $this->loadFriendIds();
        $user_id = $this->user_id;
        $recommended = [];
        $ids = [];
        if (count($this->friend_ids)) {
            $query = CommunityMember::query();
            $query->selectRaw('COUNT(community_id) as community_id_count, community_id');
            $query->whereIn('user_id', $this->friend_ids);
            $query->whereNotIn('community_id', function ($query) use ($user_id) {
                $query->select('community_id');
                $query->from(with(new CommunityMember)->getTable());
                $query->where('user_id', $user_id);
            });
            $query->whereHas('community', function ($query) {
                $query->where('type', Community::TYPES['groups']);
            });
            $query->groupBy('community_id');
            $query->orderBy('community_id_count', 'desc');
            $query->limit(5);
            $ids = $query->get()->pluck('community_id')->toArray();
        }
        $query = Community::query();
        $query->with('avatar_raw');
        $query->select(['id', 'type', 'slug', 'name']);
        if (count($ids)) {
            $query->whereIn('id', $ids);
        }
        $query->limit(5);
        return $query->get();
    }

    /**
     * @return HasMany
     */
    public function drugs()
    {
        return $this->hasMany(Drug::class, 'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function parturitions()
    {
        return $this->hasMany(Parturition::class, 'user_id', 'user_id');
    }

    /**
     * @return HasOne
     */
    public function passport()
    {
        return $this->hasOne(Passport::class, 'user_id', 'user_id');
    }

    /**
     * @return HasManyThrough
     */
    public function owners()
    {
        return $this->hasManyThrough(UserProfile::class, UserPet::class, 'pet_id', 'user_id', 'user_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function parents_relations()
    {
        return $this->hasMany(UserParent::class, 'user_id', 'user_id');
    }

    /**
     * @return array|Builder[]|Collection
     */
    public function getRelativesAttribute()
    {
        if (!$this->birthday || !$this->parents || !$this->parents->count()) return [];
        $query = self::query();
        $query->where('user_id', '!=', $this->user_id);
        $query->where('birthday', $this->birthday);
        foreach ($this->parents as $parent) {
            $query->whereHas('parents_relations', function ($query) use ($parent) {
                $query->where('parent_id', $parent->user_id);
            });
        }
        return $query->get();
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

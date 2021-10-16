<?php

namespace App\PetPassport\Models\User;

use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\PetProfile;
use App\PetPassport\Models\Shop;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    public const RESERVED_LOGINS = [
        'login',
        'register',
        'settings',
        'about',
        'market',
        'admin',
        'profile',
        'storage',
        'img',
        'image',
        'css',
        'js',
        'api'
    ];

    /**
     * @var string
     */
    protected $morphClass = 'profile';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'login',
        'email',
        'password'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//    /**
//     * @return string
//     */
//    public function getMorphClass()
//    {
//        return 'profile';
//    }

//    /**
//     * @return HasManyThrough
//     */
//    public function shops()
//    {
//        return $this->hasManyThrough(
//            Shop::class,
//            UserShop::class,
//            'user_id',
//            'id',
//            'id',
//            'shop_id'
//        );
//    }

//    /**
//     * @return HasManyThrough
//     */
//    public function pets()
//    {
//        return $this->hasManyThrough(
//            UserProfile::class,
//            UserPet::class,
//            'user_id',
//            'user_id',
//            'id',
//            'pet_id'
//        );
//    }

//    /**
//     * @return MorphMany
//     */
//    public function announcements()
//    {
//        return $this->morphMany(Announcement::class, 'owner');
//    }

//    /**
//     * @return HasMany
//     */
//    public function userSubscriptions()
//    {
//        return $this->hasMany(UserSubscription::class);
//    }

//    /**
//     * @return HasMany
//     */
//    public function userPets()
//    {
//        return $this->hasMany(UserPet::class);
//    }

    /**
     * @return HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

//    /**
//     * @return HasOne
//     */
//    public function petProfile()
//    {
//        return $this->hasOne(PetProfile::class);
//    }

//    /**
//     * @return array|mixed
//     */
//    public function getMergedProfileAttribute()
//    {
//        $profile = $this->profile;
//        if ($profile->type === 3) {
//            $profile->load('parents');
//            $profile = array_merge($profile->toArray(), $this->pet_profile->toArray());
//        } else {
//            $profile = $profile->toArray();
//        }
//        return $profile;
//    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateById($id, $data)
    {
        $keys = array_keys($data);
        if(in_array('login', $keys)) {
            UserProfile::where('user_id', $id)->update(['slug' => $data['login']]);
        }
        return $this->where('id', $id)->update($data);
    }

//    /**
//     * @return BelongsToMany
//     */
//    function friends_in()
//    {
//        return $this->belongsToMany(
//            'App\User',
//            'App\Models\UserFriend',
//            'friend_id',
//            'user_id'
//        );
//    }

//    /**
//     * @return BelongsToMany
//     */
//    function friends_in_requested()
//    {
//        return $this->friends_in()->wherePivot('accepted', false);
//    }

//    /**
//     * @return BelongsToMany
//     */
//    function friends_in_accepted()
//    {
//        return $this->friends_in()->wherePivot('accepted', true);
//    }

//    /**
//     * @return BelongsToMany
//     */
//    function friends_out()
//    {
//        return $this->belongsToMany(
//            'App\User',
//            'App\Models\UserFriend',
//            'user_id',
//            'friend_id'
//        );
//    }

//    /**
//     * @return BelongsToMany
//     */
//    function friends_out_requested()
//    {
//        return $this->friends_out()->wherePivot('accepted', false);
//    }

//    /**
//     * @return BelongsToMany
//     */
//    function friends_out_accepted()
//    {
//        return $this->friends_out()->wherePivot('accepted', true);
//    }

//    /**
//     * @return mixed
//     */
//    public function getFriendsAttribute()
//    {
//        if (!array_key_exists('friends', $this->relations)) {
//            $friends = $this->friends_in_accepted->merge($this->friends_out_accepted);
//
//            $this->setRelation('friends', $friends);
//        }
//
//        return $this->getRelation('friends');
//    }

//    /**
//     * @param $childType
//     * @param $value
//     * @param $field
//     */
//    public function resolveChildRouteBinding($childType, $value, $field)
//    {
//        // TODO: Implement resolveChildRouteBinding() method.
//    }

    /**
     * @return mixed
     */
    public function getStorageInstance()
    {
        $userId = $this->id;
        $path = "users/user-{$userId}";
        $dir = storage_path("app/public/{$path}");
        if(!Storage::has($path)) {
            Storage::makeDirectory($path);
        }
        if (!is_writable($dir)) {
            mkdir($dir, 0755, true);
        }
        return Storage::createLocalDriver(['root' => $dir, 'url' => url("storage/{$path}"), 'visibility' => 'public']);
    }
}

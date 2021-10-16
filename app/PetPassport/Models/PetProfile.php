<?php

namespace App\PetPassport\Models;

use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\User\User;
use App\PetPassport\Models\User\UserPet;
use App\PetPassport\Models\User\UserProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class PetProfile extends Model
{
    use SoftDeletes;

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
    public $table = 'pet_profiles';

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
                    'home_name' => 'A',
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
            'home_name' => $this->home_name
        ];
    }

    /**
     * @var array
     */
    protected $hidden = [
        'searchable'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'breeder_id',
        'nursery_id',
        'born_nursery_id',
        'home_name',
        'pet_type',
        'weight',
        'size',
        'titles',
        'inbreeding',
        'korung',
        'info_hidden'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'info_hidden' => 'boolean'
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasManyThrough
     */
    public function owners()
    {
        return $this->hasManyThrough(
            UserProfile::class,
            UserPet::class,
            'pet_id',
            'user_id',
            'user_id',
            'user_id'
        );
    }

    /**
     * @return BelongsTo
     */
    public function breeder()
    {
        return $this->belongsTo(UserProfile::class, 'breeder_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(UserProfile::class, 'owner_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function nursery()
    {
        return $this->belongsTo(Community::class, 'nursery_id');
    }

    /**
     * @return BelongsTo
     */
    public function born_nursery()
    {
        return $this->belongsTo(Community::class, 'born_nursery_id');
    }
}

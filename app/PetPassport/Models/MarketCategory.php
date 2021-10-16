<?php

namespace App\PetPassport\Models;

use App\PetPassport\Models\Announcement\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketCategory extends Model
{
    public const PET_TYPE_ID = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 17];

    /**
     * @return HasMany
     */
    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function siblings()
    {
        return $this->hasMany(self::class, 'parent_id', 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'category_id');
    }

    /**
     * @return mixed
     */
    public function scopeGetPetCategories()
    {
        return $this->whereIn('id', self::PET_TYPE_ID)->get();
    }
}

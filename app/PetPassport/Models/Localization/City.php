<?php

namespace App\PetPassport\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class City extends Model
{

    /**
     * @var array
     */
    public $appends = [
        'name'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        //'name_localized',
        'country_id',
        'geonameid',
        'localized'
    ];

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->localized->name ?? $this->attributes['name'];
    }

    /**
     * @return HasOne
     */
    public function localized()
    {
        return $this->hasOne(CityName::class);
    }

//    /**
//     * @param $query
//     * @param $lang
//     * @return mixed
//     */
//    public function scopeLocalized($query, $lang)
//    {
//        $query->select('cities.*', 'city_names.name as name_localized');
//        $query->leftJoin('city_names', function($q) use ($lang) {
//            $q->on('city_names.city_id', '=', 'cities.id');
//            $q->where('city_names.lang', $lang);
//        });
//        return $query;
//    }
}

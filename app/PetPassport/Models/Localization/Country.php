<?php

namespace App\PetPassport\Models\Localization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
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
        'localized',
        'geonameid'
    ];

    /**
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this->localized->name ?? $this->attributes['name'];
    }

//    /**
//     * @param $query
//     * @param $lang
//     * @return mixed
//     */
//    public function scopeLocalized($query, $lang)
//    {
//        $query->select('countries.*', 'country_names.name as name_localized');
//        $query->leftJoin('country_names', function($q) use ($lang) {
//            $q->on('country_names.country_id', '=', 'countries.id');
//            $q->where('country_names.lang', $lang);
//        });
//        return $query;
//    }

    /**
     * @return HasOne
     */
    public function localized()
    {
        return $this->hasOne(CountryName::class);
    }
}

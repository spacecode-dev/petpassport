<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Localization\City;

class CitiesController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $lang = $request->lang ?? 'en';
        $countries = City::with(['localized' => function ($query) use ($lang) {
            $query->where('lang', $lang);
        }])->where('country_id', $request->country_id)->get();
        return $countries;
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }
}

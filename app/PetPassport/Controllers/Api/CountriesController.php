<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Localization\Country;

class CountriesController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $lang = $request->lang ?? 'en';
        return Country::with([
            'localized' => function ($query) use ($lang) {
                $query->where('lang', $lang);
            }
        ])->get();
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

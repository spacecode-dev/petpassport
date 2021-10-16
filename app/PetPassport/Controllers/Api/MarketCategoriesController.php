<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\PetPassport\Models\MarketCategory;
use App\PetPassport\Models\Announcement\Announcement;

class MarketCategoriesController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $query = MarketCategory::query();
        if ($request->parent_id) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->whereNull('parent_id');
        }
        if ($request->owner_id && $request->owner_type) {
            $ann_query = Announcement::query();
            $ann_query->withoutGlobalScopes();
            $ann_query->select([
                'category_id'
            ]);
            $ann_query->where('owner_id', $request->owner_id);
            $ann_query->where('owner_type', $request->owner_type);
            $ann_query->groupBy('category_id');

            $cat_ids = $ann_query->get()->pluck('category_id');

            $query->where(function ($query) use ($cat_ids) {
                $query->whereIn('id', $cat_ids);
                $query->orWhereHas('childrens', function ($query) use ($cat_ids) {
                    $query->whereIn('id', $cat_ids);
                });
            });
        }
        return $query->get();
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

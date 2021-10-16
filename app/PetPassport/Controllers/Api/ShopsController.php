<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PetPassport\Models\Shop;

class ShopsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 20;
        $query = Shop::query();
        if ($request->user_id) {
            $query->whereHas('ownerships', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            });
        }
        if ($request->q) {
            $query->where('name', 'ilike', '%' . $request->q . '%');
        }
        if (!$request->order || $request->order == 'created_at-desc') {
            $query->orderBy('created_at', 'desc');
        }
        if ($request->order == 'created_at-asc') {
            $query->orderBy('created_at', 'asc');
        }
        $total = $query->count();
        $query->skip($offset);
        $query->take($limit);
        $shops = $query->get();
        return [
            'total' => $total,
            'shops' => $shops
        ];
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
     * @return mixed
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        $shop->append([
            'cover',
            'owned'
        ]);
        return $shop;
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

<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Shop;
use App\PetPassport\Models\User\UserShop;
use Illuminate\Http\Response;

class UserShopController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return $request->user()->shops;
    }

    /**
     * @param Request $request
     * @return Shop
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $shop = new Shop;
        $shop->fill($request->input());
        $shop->save();
        $shopUser = new UserShop;
        $shopUser->user_id = $user->id;
        $shopUser->shop_id = $shop->id;
        $shopUser->save();
        $user->profile()->increment('rating', 2000);
        return $shop;
    }

    /**
     * @param Request $request
     * @param $id
     * @return ResponseFactory|Response
     */
    public function show(Request $request, $id)
    {
        $shop = $request->user()->shops()->find($id);
        if (!$shop) return response(null, 404);
        return $shop;
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $shop = $request->user()->shops()->where('id', $id)->first();
        $shop->fill($request->input());
        $shop->save();
        return $shop;
    }

    /**
     * @param Request $request
     * @param $id
     * @return ResponseFactory|Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->shops()->where('id', $id)->delete();
        UserShop::where('user_id', $request->user()->id)->where('shop_id', $id)->delete();
        return response(null, 200);
    }
}

<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\CartItem;
use App\PetPassport\Models\Message;
use App\PetPassport\Models\User\UserShop;

class CartItemsController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = CartItem::query();
        $query->with([
            'announcement',
            'announcement.photo',
            'announcement.owner:id,name'
        ]);
        $query->where('user_id', $user->id);
        return $query->get();
    }

    public function create()
    {
        //
    }

    /**\
     * @param Request $request
     * @return CartItem
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $item = new CartItem;
        $item->user_id = $user->id;
        $item->announcement_id = $request->announcement_id;
        $item->count = $request->count ?? 1;
        $item->save();
        return $item;
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
     * @return Builder|Builder[]|Collection
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $item = CartItem::query();
        $item->where('user_id', $user->id);
        $item->where('announcement_id', $id);
        $item->update([
            'count' => $request->count ?? 1
        ]);
        $item = $item->get();
        return $item;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $query = CartItem::query();
        $query->where('user_id', $user->id);
        $query->where('announcement_id', $id);
        $query->delete();
        return response()->json(null, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function order(Request $request)
    {
        $user = $request->user();
        $query = CartItem::query();
        $query->whereHas('announcement', function ($query) use ($request) {
            $query->where('owner_id', $request->owner_id);
            $query->where('owner_type', 'shop');
        });
        $items = $query->get();
        // TODO: send to seller
        $body = 'Новый заказ в магазине';
//        foreach ($items as $item) {
//            # code...
//        }
        $owners = UserShop::where('shop_id', $request->owner_id)->get();
        foreach ($owners as $owner) {
            $message = new Message;
            $message->sender_id = $user->id;
            $message->sender_type = 'profile';
            $message->recipient_id = $owner->user_id;
            $message->recipient_type = 'profile';
            $message->body = $body;
            $message->save();
        }
        $query->delete();
        return response()->json(null, 200);
    }
}

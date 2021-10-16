<?php

namespace App\PetPassport\Controllers\Api;

use App\PetPassport\Requests\Users\UpdateUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\User;
use App\PetPassport\Models\CartItem;
use App\PetPassport\Models\User\UserFriend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     * @param User $user
     */
    function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $user->profile;
//        if ($profile->type === 3) {
//            $profile->load(['parents']);
//            $user->pet_profile->load([
//                'owner',
//                'breeder',
////                'nursery:id,type,slug,name',
////                'born_nursery:id,type,slug,name'
//            ]);
//            $profile = collect($profile)->merge($user->pet_profile->toArray())->toArray();
//        }
//        $friends_count = UserFriend::where(function ($query) use ($user) {
//            $query->where('user_id', $user->id);
//            $query->orWhere('friend_id', $user->id);
//        })
//            ->where('accepted', true)
//            ->count();
//        $friend_requests_count = UserFriend::where('friend_id', $user->id)
//            ->where('accepted', false)
//            ->count();

        return response()->json([
            'user' => $user
        ], 200);
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request)
    {
        $data = $request->only($this->user->getFillable());
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $this->user->updateById(Auth::id(), $data);
        return response()->json(['message' => 'Успешное обновление'], 200);

        //TODO currency//
//        if ($request->currency && $request->currency != $user->currency) {
//            if ($user->balance) {
//                $transaction = new UpdateUserRequest;
//                $transaction->user_id = $user->id;
//                $transaction->opcode = 101;
//                $transaction->amount = -$user->balance;
//                $transaction->currency = $user->currency;
//                $transaction->save();
//
//                $user->balance = 0;
//            }
//        }
//        $user->fill($request->input());
//        $user->save();
//        $user->profile->slug = $user->login;
//        $user->profile->save();
//        return response()->json($user);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->profile->slug = null;
        $user->profile->save();
        $user->announcements()->delete();
        $user->user_subscriptions()->delete();
        $user->delete();
        return response()->json(null, 200);
    }
}

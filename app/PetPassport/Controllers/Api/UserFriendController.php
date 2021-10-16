<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserFriend;
use App\PetPassport\Models\User\UserSubscription;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Events\FriendshipReceived;
use App\PetPassport\Events\FriendshipAccepted;

class UserFriendController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $friendships = UserFriend::where(function ($query) use ($user) {
            $query->where('user_id', $user->id);
            $query->orWhere('friend_id', $user->id);
        })
            ->where('accepted', true)
            ->paginate(15);
        $friendship_items = $friendships->getCollection();
        $ids1 = $friendship_items->pluck('user_id');
        $ids2 = $friendship_items->pluck('friend_id');
        $ids = array_diff($ids1->merge($ids2)->toArray(), [$user->id]);
        $friends = UserProfile::whereIn('user_id', $ids)->get();
        $result = $friendships->toArray();
        $result['data'] = $friends;
        return $result;
    }

    public function requests(Request $request)
    {
        $user = $request->user();
        $requests = UserFriend::where('friend_id', $user->id)->where('accepted', false)->get();
        $result = [];
        if ($requests->count()) {
            $ids = $requests->pluck('user_id');
            $result = UserProfile::whereIn('user_id', $ids)->get();
        }
        return $result;
    }

    /**
     * @param Request $request
     * @return UserFriend
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $incomingFriendship = UserFriend::where('friend_id', $user->id)->where('user_id', $request->friend_id)->first();
        if ($incomingFriendship) {
            $incomingFriendship->accepted = true;
            $incomingFriendship->save();
            event(new FriendshipAccepted($incomingFriendship->user_id, $incomingFriendship->side2));
            return $incomingFriendship;
        }
        $friendship = new UserFriend;
        $friendship->user_id = $user->id;
        $friendship->friend_id = $request->friend_id;
        $friendship->save();
        UserSubscription::firstOrCreate([
            'user_id' => $user->id,
            'wall_id' => $request->friend_id,
            'wall_type' => 'profile'
        ]);
        event(new FriendshipReceived($friendship->friend_id, $friendship->side1));
        return $friendship;
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        UserFriend::where('friend_id', $user->id)->where('user_id', $id)->update([
            'accepted' => true
        ]);
        return response()->json(null, 200);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        UserFriend::where(function ($query) use ($user) {
            $query->where('user_id', $user->id);
            $query->orWhere('friend_id', $user->id);
        })
            ->where(function ($query) use ($id) {
                $query->where('user_id', $id);
                $query->orWhere('friend_id', $id);
            })
            ->delete();
        UserSubscription::where('user_id', $user->id)
            ->where('wall_id', $id)
            ->where('wall_type', 'profile')
            ->delete();
        return response()->json(null, 200);
    }
}

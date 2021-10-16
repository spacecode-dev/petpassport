<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Community\CommunityMember;
use App\PetPassport\Models\User\UserSubscription;

class CommunityMembersController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 15;
        $query = CommunityMember::query();
        $query->with('member');
        $query->where('community_id', $request->community_id);
        if ($request->q) {
            $query->whereHas('member', function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request->q . '%');
            });
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
        $subs = $query->get();
        $users = $subs->pluck('member');
        return [
            'members' => $users,
            'total' => $total
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user('api');
        if (!$user) {
            return response()->json(null, 403);
        }
        CommunityMember::firstOrCreate([
            'community_id' => $request->community_id,
            'user_id' => $user->id
        ]);
        UserSubscription::firstOrCreate([
            'user_id' => $user->id,
            'wall_id' => $request->community_id,
            'wall_type' => 'community'
        ]);
        Community::where('id', $request->community_id)->increment('rating');
        return response()->json(null, 200);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $user = $request->user('api');
        $user_id = $request->user_id ?? $user->id;
        if ($user_id != $user->id) {
            $query_count = Community::query();
            $query_count->where('community_id', $request->community_id);
            $query_count->where('user_id', $user->id);
            $count = $query_count->count();
            if (!$count) {
                return response()->json(null, 403);
            }
        }
        $query_member = CommunityMember::query();
        $query_member->where('community_id', $request->community_id);
        $query_member->where('user_id', $user_id);
        $query_member->delete();
        $query_sub = UserSubscription::query();
        $query_sub->where('user_id', $user_id);
        $query_sub->where('wall_id', $request->community_id);
        $query_sub->where('wall_type', 'community');
        $query_sub->delete();
        Community::where('id', $request->community_id)->decrement('rating');
        return response()->json(null, 200);
    }
}

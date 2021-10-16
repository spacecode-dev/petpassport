<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Community\CommunityMember;
use App\PetPassport\Models\Like;

class UserCommunitiesController extends Controller
{
    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        //
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
     * @param Request $request
     * @param $id
     * @return array
     */
    public function show(Request $request, $id)
    {
        $query = CommunityMember::with('community')->where('user_id', $id);
        if (in_array($request->type, [1, 2])) {
            $query->whereHas('community', function ($q) use ($request) {
                $q->where('type', $request->type);
            });
            if ($request->q) {
                $query->whereHas('community', function ($query) use ($request) {
                    $query->where('name', 'ilike', '%' . $request->q . '%');
                });
            }
            $query->withCount('members');
        }
        if (in_array($request->type, [3, 4])) {
            $query = Like::with('object')->where('user_id', $id)->where('object_type', 'community');
            if ($request->q) {
                $query->whereHas('object', function ($query) use ($request) {
                    $query->where('name', 'ilike', '%' . $request->q . '%');
                });
            }
            $query->withCount('likes');
        }
        if (!$request->order || $request->order == 'created_at-desc') {
            $query->orderBy('created_at', 'desc');
        }
        if ($request->order == 'created_at-asc') {
            $query->orderBy('created_at', 'asc');
        }
        $total = $query->count();
        $communities = $query->get();
        if (in_array($request->type, [1, 2])) {
            $communities->each(function ($item, $key) {
                $item->community->members_count = $item->members_count;
                $item->community->likes_count = $item->likes_count;
            });
            $communities = $communities->pluck('community');
        }
        if (in_array($request->type, [3, 4])) {
            $communities->each(function ($item, $key) {
                $item->object->members_count = $item->members_count;
                $item->object->likes_count = $item->likes_count;
            });
            $communities = $communities->pluck('object');
        }
        return [
            'total' => $total,
            'communities' => $communities
        ];
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

<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserFriend;

class FriendsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 15;
        $query = UserFriend::query();
        $query->with([
            'side1',
            'side2'
        ]);
        $query->where(function ($query) use ($request) {
            $query->where('user_id', $request->user_id);
            $query->orWhere('friend_id', $request->user_id);
        });
        $query->where('accepted', true);
        if ($request->q) {
            $scope = function ($query) use ($request) {
                $query->where('user_id', '!=', $request->user_id);
                $query->where('name', 'ilike', '%' . $request->q . '%');
            };
            $query->where(function ($query) use ($scope) {
                $query->whereHas('side1', $scope);
                $query->orWhereHas('side2', $scope);
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
        $friendships = $query->get();
        $friends = [];
        foreach ($friendships as $friendship) {
            if ($friendship->side1->user_id != $request->user_id) {
                $friends[] = $friendship->side1;
            } else {
                $friends[] = $friendship->side2;
            }
        }
        return [
            'friends' => $friends,
            'total' => $total
        ];
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

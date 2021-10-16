<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Community\CommunityUser;

class CommunityUsersController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $query = CommunityUser::query();
        $query->with('user:user_id,slug,name');
        $query->where('community_id', $request->community_id);
        return $query->get();
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
        $query = CommunityUser::query();
        $query->where('community_id', $request->community_id);
        $query->where('user_id', $request->user_id);
        $query->where('type', $request->type);
        if ($query->exists()) {
            return response()->json([
                'code' => 2,
                'error' => 'Данный профиль уже привязан'
            ], 422);
        }
        $link = new CommunityUser;
        $link->community_id = $request->community_id;
        $link->user_id = $request->user_id;
        $link->type = $request->type;
        $link->save();
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
        $query = CommunityUser::query();
        $query->where('community_id', $request->community_id);
        $query->where('user_id', $request->user_id);
        $query->where('type', $request->type);
        $query->delete();
        return response()->json(null, 200);
    }
}

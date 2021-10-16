<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Community\CommunityRole;

class CommunityRolesController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $query = CommunityRole::query();
        $query->with('profile:user_id,name,slug');
        $query->where('community_id', $request->community_id);
        return $query->get();
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return CommunityRole|JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user('api');
        if ($request->user_id == $user->id) {
            return response()->json([
                'code' => 1,
                'error' => 'Невозможно добавить в команду самого себя'
            ], 422);
        }
        $queryCurrent = CommunityRole::query();
        $queryCurrent->where('community_id', $request->community_id);
        $queryCurrent->where('user_id', $user->id);
        $currentRole = $queryCurrent->first();
        if (!$currentRole || $currentRole->role != CommunityRole::ROLES['owner']) {
            return response()->json(null, 403);
        }
        $query = CommunityRole::query();
        $query->where('community_id', $request->community_id);
        $query->where('user_id', $request->user_id);
        $query->delete();
        $role = new CommunityRole;
        $role->fill($request->input());
        $role->save();
        $role->load('profile');
        return $role;
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
        // TODO security check
        $query = CommunityRole::query();
        $query->where('community_id', $request->community_id);
        $query->where('user_id', $request->user_id);
        $query->delete();
        return response()->json(null, 200);
    }
}

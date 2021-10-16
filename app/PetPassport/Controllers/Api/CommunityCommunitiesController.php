<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Community\CommunityCommunity;
use Illuminate\Support\Collection;

class CommunityCommunitiesController extends Controller
{
    /**
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        $query = CommunityCommunity::query();
        $query->with('linked:id,type,slug,name');
        $query->where('community_id', $request->community_id);
        return $query->get()->pluck('linked');
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
        if ($request->community_id == $request->linked_id) {
            return response()->json([
                'code' => 1,
                'error' => 'Невозможно привязать сообщество к самому себе'
            ], 422);
        }
        $query = CommunityCommunity::query();
        $query->where('community_id', $request->community_id);
        $query->where('linked_id', $request->linked_id);
        if ($query->exists()) {
            return response()->json([
                'code' => 2,
                'error' => 'Данное сообщество уже привязано'
            ], 422);
        }
        $link = new CommunityCommunity;
        $link->community_id = $request->community_id;
        $link->linked_id = $request->linked_id;
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
        $query = CommunityCommunity::query();
        $query->where('community_id', $request->community_id);
        $query->where('linked_id', $request->linked_id);
        $query->delete();
        return response()->json(null, 200);
    }
}

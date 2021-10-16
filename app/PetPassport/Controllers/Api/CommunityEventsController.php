<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Community\CommunityEvent;

class CommunityEventsController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $query = CommunityEvent::query();
        $query->where('community_id', $request->community_id);
        $query->orderBy('start_at', 'asc');
        return $query->get();
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return CommunityEvent
     */
    public function store(Request $request)
    {
        $event = new CommunityEvent;
        $event->fill($request->input());
        $event->save();
        return $event;
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        CommunityEvent::where('id', $id)->delete();
        return response()->json(null, 200);
    }
}

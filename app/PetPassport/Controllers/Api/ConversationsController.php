<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\PetPassport\Models\User\UserConversation;

class ConversationsController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = UserConversation::query();
        $query->with('recipient');
        $query->where('user_id', $user->id);
        $query->orderBy('created_at', 'desc');
        return $query->get();
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

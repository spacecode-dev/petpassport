<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PetPassport\Models\Message;

class MessagesController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 20;
        $user = $request->user();
        $query = Message::query();
        $query->with('sender');
        $query->where(function ($query) use ($user, $request) {
            $query->where('sender_id', $user->id);
            $query->where('sender_type', 'profile');
            $query->where('sender_deleted', false);
            $query->where('recipient_id', $request->recipient_id);
            $query->where('recipient_type', $request->recipient_type);
        });
        $query->orWhere(function ($query) use ($user, $request) {
            $query->where('sender_id', $request->recipient_id);
            $query->where('sender_type', $request->recipient_type);
            $query->where('recipient_id', $user->id);
            $query->where('recipient_type', 'profile');
            $query->where('recipient_deleted', false);
        });
        $total = $query->count();
        $query->orderBy('id', 'desc');
        $query->skip($offset);
        $query->take($limit);
        $messages = $query->get();
        return [
            'messages' => $messages,
            'total' => $total
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return Message
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $message = new Message;
        $message->fill($request->input());
        $message->sender_id = $user->id;
        $message->sender_type = 'profile';
        $message->save();
        $message->load('sender');
        return $message;
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

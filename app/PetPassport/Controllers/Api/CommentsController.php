<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Comment;
use App\PetPassport\Models\Like;

class CommentsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 20;
        $user = $request->user('api');
        // TODO: permission check
        $query = Comment::query();
        $query->with('owner');
        $query->withCount('likes');
        $query->where('object_id', $request->object_id);
        $query->where('object_type', $request->object_type);
        $query->orderBy('id', 'desc');
        $query->skip($offset);
        $query->take($limit);
        $total = $query->count();
        $comments = $query->get();
        $liked = [];
        if ($user && $comments->count()) {
            $ids = $comments->pluck('id');
            if (count($ids)) {
                $liked = Like::whereIn('object_id', $ids)
                    ->where('object_type', 'comment')
                    ->where('user_id', $user->id)
                    ->get()
                    ->pluck('object_id');
            }
        }
        return [
            'comments' => array_reverse($comments->toArray()),
            'liked' => $liked,
            'total' => $total
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return Comment
     */
    public function store(Request $request)
    {
        $user = $request->user('api');
        $comment = new Comment;
        $comment->object_id = $request->object_id;
        $comment->object_type = $request->object_type;
        $comment->owner_id = $user->id;
        $comment->owner_type = 'profile';
        $comment->body = $request->body;
        $comment->save();
        return $comment;
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
        // TODO: permissions check
        $comment = Comment::find($id);
        $comment->likes()->delete();
        $comment->delete();
        return response()->json(null, 200);
    }
}

<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PetPassport\Events\LikeCreated;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Like;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\Media\Photo;
use App\PetPassport\Models\Media\Video;
use App\PetPassport\Events\LikeUpdated;

class LikesController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
//        $offset = $request->offset ?? 0;
//        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 20;
//        $query = Like::query();
//        $query->with('user');
//        $query->where('object_id', $request->object_id);
//        $query->where('object_type', $request->object_type);
//        if ($request->q) {
//            $query->whereHas('user', function ($query) use ($request) {
//                $query->where('name', 'ilike', '%' . $request->q . '%');
//            });
//        }
//        if (!$request->order || $request->order == 'created_at-desc') {
//            $query->orderBy('created_at', 'desc');
//        }
//        if ($request->order == 'created_at-asc') {
//            $query->orderBy('created_at', 'asc');
//        }
//        $total = $query->count();
//        $query->skip($offset);
//        $query->take($limit);
//        $likes = $query->get();
//        return [
//            'total' => $total,
//            'likes' => $likes
//        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function like(Request $request)
    {
        $user = $request->user();
        $objectId = $request->get('object_id');
        $objectType = $request->get('object_type');
        Like::firstOrCreate([
            'object_id' => $objectId,
            'object_type' => $objectType,
            'user_id' => $user->id
        ]);
        if ($objectType === 'community') {
            Community::where('id', $objectId)->increment('rating');
        }
        if ($objectType === 'post') {
            $post = Post::withoutGlobalScopes()->withCount('likes')->find($objectId);
            if ($post->owner_type === 'profile' && $post->owner_id !== $user->id) {
                broadcast(new LikeCreated('private-user.' . $post->owner_id, $post->id, 'post', $user->profile));
            }
            broadcast(new LikeUpdated('wall.' . $post->wall_type . '.' . $post->wall_id, $post->id, 'post', $post->likes_count))->toOthers();
        }
        if ($objectType === 'photo') {
            $photo = Photo::withoutGlobalScopes()->withCount('likes')->find($objectId);
            if ($photo->owner_type == 'profile' && $photo->owner_id !== $user->id) {
                broadcast(new LikeCreated('private-user.' . $photo->owner_id, $photo->id, 'photo', $user->profile));
            }
        }
        if ($objectType === 'video') {
            $video = Video::withoutGlobalScopes()->withCount('likes')->find($objectId);
            if ($video->owner_type == 'profile' && $video->owner_id !== $user->id) {
                broadcast(new LikeCreated('private-user.' . $video->owner_id, $video->id, 'video', $user->profile));
            }
        }
//        $like = new Like;
//        $like->object_id = $objectId;
//        $like->object_type = $objectType;
//        $like->user_id = $user->id;
//        $like->save();
        return response()->json(null, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function dislike(Request $request)
    {
        $user = $request->user();
        $objectId = $request->get('object_id');
        $objectType = $request->get('object_type');
        $query = Like::query();
        $query->where('object_id', $objectId);
        $query->where('object_type', $objectType);
        $query->where('user_id', $user->id);
        $query->delete();
        if ($objectType === 'community') {
            Community::where('id', $objectId)->decrement('rating');
        }
        if ($objectType === 'post') {
            $post = Post::withCount('likes')->find($objectId);
            broadcast(new LikeUpdated('wall.' . $post->wall_type . '.' . $post->wall_id, $post->id, 'post', $post->likes_count))->toOthers();
        }
        return response()->json(null, 200);
    }
}

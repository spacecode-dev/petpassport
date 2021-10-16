<?php

namespace App\PetPassport\Controllers\Api;

use App\PetPassport\Models\Media\Photo;
use App\PetPassport\Services\GetFiles;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\PostAttachment;
use App\PetPassport\Models\Media\Video;
use App\PetPassport\Models\Community\Community;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function show(Request $request)
    {
        $offset = $request->get('offset') ?? 0;
        $limit = ($request->get('limit') && intval($request->get('limit')) <= 100) ? $request->get('limit') : 20;
        $query = Post::query();
        $query->withCounters();
        $query->privacyCheck();
        if ($request->has('reason') && $request->get('reason') === 'wall') {
            $wall_type = $request->get('wall_type') ?? 'profile';
            $query->where('wall_id', $request->get('wall_id'));
            $query->where('wall_type', $wall_type);
        }
//        if ($request->reason == 'news') {
//            $user = $request->user('api');
//            $subs = $user->user_subscriptions->groupBy('wall_type');
//            if ($subs->count()) {
//                $i = 0;
//                foreach ($subs as $wall_type => $s) {
//                    $ids = $s->pluck('wall_id');
//                    $closure = function ($q) use ($ids, $wall_type) {
//                        $q->whereIn('owner_id', $ids);
//                        $q->where('owner_type', $wall_type);
//                    };
//                    $i == 0 ? $query->where($closure) : $query->orWhere($closure);
//                    $i++;
//                }
//                $query->whereColumn('wall_id', 'owner_id');
//                $query->whereColumn('wall_type', 'owner_type');
//            }
//        }
//        if ($request->reason == 'sos') {
//            $query->where('sos', true);
//        }
        $query->orderBy('id', 'desc');
        $query->skip($offset);
        $query->take($limit);
        $posts = $query->get();
        $posts->sanitize();
        $posts->attachFlags();
        return $posts;
    }

    /**
     * @param Request $request
     * @return Post
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->fill($request->input());
        $post->save();
        if ($request->has('wall_type') && $request->get('wall_type') === 'community') {
            Community::where('id', $request->get('wall_id'))->increment('rating');
        }
        if($request->has('photos') && count($request->get('photos')) > 0) {
            $attr = [];
            foreach ($request->get('photos') as $photo) {
                $attr[] = [
                    'post_id' => $post->id,
                    'attachment_id' => Photo::where('original', parse_url($photo['path'])['path'])->first()->id,
                    'attachment_type' => 'photo'
                ];
            }
            PostAttachment::insert($attr);
        }

//        if (filter_var($post->body, FILTER_VALIDATE_URL)) {
//            try {
//                $video = Video::createFromUrl($post->body);
//                if ($video) {
//                    $video->owner_id = $post->owner_id;
//                    $video->owner_type = $post->owner_type;
//                    $video->save();
//                    $att = new PostAttachment;
//                    $att->post_id = $post->id;
//                    $att->attachment_id = $video->id;
//                    $att->attachment_type = 'video';
//                    $att->save();
//                }
//            } catch (Exception $e) {
//                //dd($e);
//            }
//        }
        $post = Post::withCounters()->find($post->id);
        return $post;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        // TODO access check
        $post = Post::find($id);
        $post->fill($request->input());
        $post->save();
        return response()->json(null, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy( $id)
    {
        // TODO access check
        $post = Post::find($id);
        if ($post->wall_type === 'community') {
            Community::where('id', $post->wall_id)->decrement('rating');
        }
        $post->likes()->delete();
        $post->delete();
        return response()->json(null, 200);
    }
}

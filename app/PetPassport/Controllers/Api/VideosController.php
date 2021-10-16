<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PetPassport\Models\Media\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Media\Video;
use App\PetPassport\Models\Media\VideoAlbum;
use App\PetPassport\Exceptions\EmbedNotFoundException;
use App\PetPassport\Exceptions\EmbedNotAllowedException;

class VideosController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 25;
        $album = null;
        if ($request->filled('album_id')) {
            $album = VideoAlbum::find($request->album_id);
        }
        $query = Video::withCount('likes', 'comments');
        if ($album) {
            $query->where('album_id', $album->id);
        } else if ($request->filled('owner_id') && $request->filled('owner_type')) {
            $query->where('owner_id', $request->owner_id);
            $query->where('owner_type', $request->owner_type);
            $section = $request->section ?? 1;
            $query->where('section', $section);
        }
        // TODO: privacy check
        $total = $query->count();
        $query->orderBy('id', 'desc');
        $query->skip($offset);
        $query->take($limit);
        $videos = $query->get();
        return [
            'total' => $total,
            'videos' => $videos,
            //'liked' => $videos->liked(),
            'album' => $album
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return Video|bool|JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->url) {
            try {
                $video = Video::createFromUrl($request->url);
                if (!$video) return response()->json([
                    'code' => 1
                ], 422);
                $video->fill($request->input());
                $video->save();
                return $video;
            } catch (EmbedNotFoundException $e) {
                return response()->json([
                    'code' => 2
                ], 422);
            } catch (EmbedNotAllowedException $e) {
                return response()->json([
                    'code' => 3
                ], 422);
            }
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function show(Request $request, $id)
    {
        $video = Video::find($id);
        if ($request->reason == 'album') {
            $next = Video::where('id', '<', $video->id)->where('owner_id', $video->owner_id)->where('owner_type', $video->owner_type);
            $prev = Photo::where('id', '>', $video->id)->where('owner_id', $video->owner_id)->where('owner_type', $video->owner_type);
            if ($request->album_id != 0) {
                $next->where('album_id', $request->album_id);
                $prev->where('album_id', $request->album_id);
            }
            $next = $next->orderBy('id', 'desc')->first();
            $prev = $prev->orderBy('id', 'asc')->first();
            $video->next_id = $next ? $next->id : null;
            $video->prev_id = $prev ? $prev->id : null;
        }
        $user = $request->user('api');
        if ($user) {
//            $photo->liked = (bool) PhotoLike::where('photo_id', $photo->id)
//                                            ->where('user_id', $user->id)
//                                            ->count();
        } else {
            $video->liked = false;
        }
        // TODO: privacy check
        return $video;
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
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = $request->user('api');
        $video = Video::find($id);
        if ($video->owner_type == 'profile') {
            if ($video->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        // TODO: group access check, make owner_type/owner_id not fillable
        $video->fill($request->input);
        $video->save();
        return $video;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user('api');
        $video = Video::find($id);
        if ($video->owner_type == 'profile') {
            if ($video->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        $video->delete();
//        $duplicates = Video::where('source', $video->source)->count();
//        if (!$duplicates) {
//            // TODO: remove from storage
//        }
        return response()->json(null, 200);
    }
}

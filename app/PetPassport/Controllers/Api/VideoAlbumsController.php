<?php

namespace App\PetPassport\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\PetPassport\Models\Media\Video;
use App\PetPassport\Models\Media\VideoAlbum;

class VideoAlbumsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 15;
        $query = VideoAlbum::with('cover')
            ->withCount('videos');
        $query->where('owner_id', $request->owner_id);
        $query->where('owner_type', $request->owner_type);
        // TODO: privacy check
        $total = $query->count();
        $query->orderBy('id', 'desc');
        $query->skip($offset);
        $query->take($limit);
        $albums = $query->get();
        return [
            'total' => $total,
            'albums' => $albums
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return VideoAlbum|JsonResponse
     */
    public function store(Request $request)
    {
        if (!$request->owner_id || !$request->owner_type) {
            return response()->json(null, 422);
        }
        $user = $request->user('api');
        if (!$user) {
            return response()->json(null, 403);
        }
        if ($request->owner_type == 'profile') {
            if ($request->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        if ($request->owner_type == 'community') {
            // TODO: permission check
        }
        $album = new VideoAlbum;
        $album->fill($request->input());
        $album->save();
        $album->videos_count = 0;
        return $album;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return VideoAlbum::find($id);
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
        $album = VideoAlbum::find($id);
        if ($album->owner_type == 'profile') {
            if ($album->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        // TODO: group access check, make owner_type/owner_id not fillable
        $album->fill($request->input());
        $album->save();
        return $album;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user('api');
        $album = VideoAlbum::find($id);
        if ($album->owner_type == 'profile') {
            if ($album->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        $album->delete();
        Video::where('album_id', $album->id)->delete();
        return response()->json(null, 200);
    }
}

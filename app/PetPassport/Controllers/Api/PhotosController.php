<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Media\Photo;
use App\PetPassport\Models\Like;
use App\PetPassport\Models\Media\PhotoAlbum;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\PostAttachment;

class PhotosController extends Controller
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
            $album = PhotoAlbum::find($request->album_id);
        }
        $query = Photo::withCount('likes', 'comments');
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
        $photos = $query->get();
        return [
            'total' => $total,
            'photos' => $photos,
            'album' => $album
        ];
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return array|JsonResponse
     */
    public function store(Request $request)
    {
        //if (!$request->hasFile('photo')) {
        //    return response()->json(null, 422);
        //}
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
            // TODO: group uploads
            //return response()->json(null, 422);
        }
        //$ext = $upload->getClientOriginalExtension();
        $filename = Str::random(40);
        if ($request->hasFile('photo')) {
            $upload = $request->file('photo');
            $original = Image::make($upload->getRealPath());
        } else if ($request->photo_id) {
            $photoFrom = Photo::find($request->photo_id);
            $original = Image::make(public_path($photoFrom->original));
        }
        if (!$original) {
            return response()->json(null, 422);
        }
        $photo = new Photo;
        $photo->fill($request->input());
        if ($request->crop) {
            $crop = json_decode($request->crop);
            $original->crop($crop->width, $crop->height, $crop->x, $crop->y);
        }
        if ($request->section == Photo::SECTIONS['avatar']) {
            $original->resize(500, 500);
        }
        $photo->original_width = $original->width();
        $photo->original_height = $original->height();
        $path_base = 'public/' . Photo::SECTIONS[$request->section] . 's';
        $original->backup();
        foreach (Photo::THUMB_SIZES as $size) {
            if ($original->width() <= $size) break;
            $original->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $stream = $original->stream('jpg', 80);
            $thumb = 'thumb_' . $size;
            $path = $path_base . '/' . $thumb . '/' . $filename . '.jpg';
            Storage::put($path, $stream);
            $photo->$thumb = Storage::url($path);
            $original->reset();
        }
        $stream = $original->stream('jpg', 80);
        $path = $path_base . '/original/' . $filename . '.jpg';
        Storage::put($path, $stream);
        $photo->original = Storage::url($path);
        $photo->save();
        $photo->likes_count = 0;
        $photo->comments_count = 0;
        $post = null;
        if (in_array(Photo::SECTIONS[$request->section], ['avatar', 'cover'])) {
            $post = new Post;
            $post->type = Post::TYPES[Photo::SECTIONS[$request->section]];
            $post->wall_id = $request->owner_id;
            $post->wall_type = $request->owner_type;
            $post->owner_id = $request->owner_id;
            $post->owner_type = $request->owner_type;
            $post->save();
            $att = new PostAttachment;
            $att->post_id = $post->id;
            $att->attachment_id = $photo->id;
            $att->attachment_type = 'photo';
            $att->save();
            $post = Post::withCounters()->find($post->id);
        }
        return [
            'photo' => $photo,
            'post' => $post
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function show(Request $request, $id)
    {
        $photo = Photo::find($id);
        if ($request->reason == 'album') {
            $next = Photo::where('id', '<', $photo->id)->where('owner_id', $photo->owner_id)->where('owner_type', $photo->owner_type);
            $prev = Photo::where('id', '>', $photo->id)->where('owner_id', $photo->owner_id)->where('owner_type', $photo->owner_type);
            if ($request->album_id != 0) {
                $next->where('album_id', $request->album_id);
                $prev->where('album_id', $request->album_id);
            }
            $next = $next->orderBy('id', 'desc')->first();
            $prev = $prev->orderBy('id', 'asc')->first();
            $photo->next_id = $next ? $next->id : null;
            $photo->prev_id = $prev ? $prev->id : null;
        }
        $user = $request->user('api');
        if ($user) {
            $photo->liked = Like::where('object_id', $photo->id)
                ->where('object_type', 'photo')
                ->where('user_id', $user->id)
                ->exists();
        } else {
            $photo->liked = false;
        }
        // TODO: privacy check
        return $photo;
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
        $photo = Photo::find($id);
        if ($photo->owner_type == 'profile') {
            if ($photo->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        // TODO: group access check, make owner_type/owner_id not fillable
        $photo->fill($request->input);
        $photo->save();
        return $photo;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user('api');
        $photo = Photo::find($id);
        if ($photo->owner_type == 'profile') {
            if ($photo->owner_id != $user->id) {
                return response()->json(null, 403);
            }
        }
        $photo->delete();
//        $duplicates = Photo::where('original', $photo->original)->count();
//        if (!$duplicates) {
//            // TODO: remove from storage
//        }
        return response()->json(null, 200);
    }
}

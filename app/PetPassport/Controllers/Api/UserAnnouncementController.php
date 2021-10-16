<?php

namespace App\PetPassport\Controllers\Api;

use App\PetPassport\Requests\Announcements\StoreUserAnnouncementRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\Announcement\AnnouncementPet;
use App\PetPassport\Models\Announcement\AnnouncementPhoto;
use App\PetPassport\Models\Post;
use App\PetPassport\Models\PostAttachment;
use App\PetPassport\Models\Like;
use Illuminate\Http\Response;

class UserAnnouncementController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($request->shop_id) {
            $query = Announcement::query();
            $query->with('photo');
            $query->where('owner_id', $request->shop_id);
            $query->where('owner_type', 'shop');
            $query->orderBy('id', 'desc');
            $counters = [
                'views_today' => $query->sum('views_today'),
                'views' => $query->sum('views')
            ];
            $announcements = $query->get();
        } else {
            $announcements = $user->announcements()->with('photo')->orderBy('id', 'desc')->get();
            $counters = [
                'views_today' => $user->announcements()->sum('views_today'),
                'views' => $user->announcements()->sum('views')
            ];
        }
        return [
            'announcements' => $announcements,
            'counters' => $counters
        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $user = $request->user();
        $user->load('pets');
        return response()->json(['pets' => $user->pets]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserAnnouncementRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserAnnouncementRequest $request)
    {
        $user = $request->user();
        $announcement = new Announcement;
        $announcement->fill($request->input());
        $announcement->type = 1;
        if ($request->shop_id) {
            $announcement->owner_id = $request->shop_id;
            $announcement->owner_type = 'shop';
        } else {
            $announcement->owner_id = $user->id;
            $announcement->owner_type = 'profile';
        }
        $announcement->save();
        $pet = new AnnouncementPet;
        $pet->fill($request->input());
        $pet->announcement_id = $announcement->id;
        $pet->save();
        if ($request->photos) {
            // TODO: security, mass insert
            foreach ($request->photos as $photo_id) {
                $photo = new AnnouncementPhoto;
                $photo->announcement_id = $announcement->id;
                $photo->photo_id = $photo_id;
                $photo->save();
            }
        }
        if ($request->publish_owner) {
            $post = new Post;
            $post->wall_id = $user->id;
            $post->wall_type = 'profile';
            if ($request->shop_id) {
                $post->owner_id = $request->shop_id;
                $post->owner_type = 'shop';
            } else {
                $post->owner_id = $user->id;
                $post->owner_type = 'profile';
            }
            $post->save();
            $attachment = new PostAttachment;
            $attachment->post_id = $post->id;
            $attachment->attachment_id = $announcement->id;
            $attachment->attachment_type = 'announcement';
            $attachment->save();
        }
        if ($request->publish_pet && $pet->pet_id) {
            $post = new Post;
            $post->wall_id = $pet->pet_id;
            $post->wall_type = 'profile';
            if ($request->shop_id) {
                $post->owner_id = $request->shop_id;
                $post->owner_type = 'shop';
            } else {
                $post->owner_id = $pet->pet_id;
                $post->owner_type = 'profile';
            }
            $post->save();
            $attachment = new PostAttachment;
            $attachment->post_id = $post->id;
            $attachment->attachment_id = $announcement->id;
            $attachment->attachment_type = 'announcement';
            $attachment->save();
        }
        $user->profile()->increment('rating', 100);
        return response()->json($announcement);
    }

    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|JsonResponse
     */
    public function edit(Request $request, $id)
    {
        $user = $request->user();
        $user->load('pets', 'pets.pet_profile');
        //$announcement = $user->announcements()->with('photos')->where('id', $id)->first();
        $announcement = Announcement::with('photos')->find($id);
        if ($announcement) {
            $announcement->append('parent_category_id');
            $ann = $announcement->toArray();
            $pet = AnnouncementPet::where('announcement_id', $announcement->id)->first();
            if ($pet) {
                $ann = array_merge($ann, $pet->toArray());
            }
            return [
                'announcement' => $ann,
                'pets' => $user->pets
            ];
        }
        return response()->json(null, 422);
    }

    /***
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        // TODO: security
        $announcement = Announcement::find($id);
        $announcement->fill($request->input());
        $announcement->save();
        $ann = $announcement->toArray();
        $pet = AnnouncementPet::where('announcement_id', $announcement->id)->first();
        if ($pet) {
            $pet->fill($request->input());
            $pet->save();
            $ann = array_merge($ann, $pet->toArray());
        }
        AnnouncementPhoto::where('announcement_id', $announcement->id)->delete();
        if ($request->photos) {
            // TODO: security, mass insert
            foreach ($request->photos as $photo_id) {
                $photo = new AnnouncementPhoto;
                $photo->announcement_id = $announcement->id;
                $photo->photo_id = $photo_id;
                $photo->save();
            }
        }
//        if (true) {
//            $post = new Post;
//            $post->wall_id = $user->id;
//            $post->wall_type = 1;
//            $post->owner_id = $user->id;
//            $post->owner_type = 1;
//            $post->save();
//
//            $attachment = new PostAttachment;
//            $attachment->post_id = $post->id;
//            $attachment->attachment_id = $announcement->id;
//            $attachment->attachment_type = 'announcement';
//            $attachment->save();
//        }
        return $ann;
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        // TODO: security
        $ann = Announcement::find($id);
        if ($ann) {
            AnnouncementPet::where('announcement_id', $ann->id)->delete();
            AnnouncementPhoto::where('announcement_id', $ann->id)->delete();
            Like::where('object_id', $ann->id)->where('object_type', 'announcement')->delete();
            $ann->delete();
            return response()->json(null, 200);
        }
        return response()->json(null, 422);
    }

    public function favorites_index()
    {
        //
    }

    /**
     * @param Request $request
     */
    public function favorites_store(Request $request)
    {
        //
    }

    /**
     * @param $id
     */
    public function favorites_destroy($id)
    {
        //
    }
}

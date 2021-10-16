<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Community\Community;
use App\PetPassport\Models\Community\CommunityMember;
use App\PetPassport\Models\Like;
use App\PetPassport\Models\Community\CommunityRole;
use App\PetPassport\Models\Community\CommunityProfileNursery;
use App\PetPassport\Models\Community\CommunityProfileBreed;

class CommunitiesController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 20;
        if ($request->reason == 'search') {
            //$user = $request->user('api');
            $query = Community::query();
            if ($request->type) {
                $query->where('type', $request->type);
            }
            if ($request->types) {
                $query->whereIn('type', explode(',', $request->types));
            }
            if ($request->q) {
                $s = explode('/', urldecode($request->q));
                $s = end($s);
                $query->where(function ($query) use ($s) {
                    $query->where('slug', $s);
                    if (ctype_digit($s)) {
                        $query->orWhere('id', $s);
                    }
                    $query->orWhere('name', 'ilike', '%' . $s . '%');
                });
            }
            $total = $query->count();
            $communities = $query->get();
            return [
                'communities' => $communities,
                'total' => $total
            ];
        }
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return Community|JsonResponse
     */
    public function store(Request $request)
    {
        if (in_array(strtolower($request->slug), Community::RESERVED_SLUGS)) {
            return response()->json([
                'code' => 1,
                'error' => 'Невозможно использовать указанный адрес страницы'
            ], 422);
        }
        if (!preg_match('/^[a-z0-9_]+$/i', $request->slug)) {
            return response()->json([
                'code' => 2,
                'error' => 'Адрес страницы может содержать только латинские буквы, цифры, и символ подчеркивания'
            ], 422);
        }
        $exists = Community::where('slug', $request->slug)->exists();
        if ($exists) {
            return response()->json([
                'code' => 3,
                'error' => 'Адрес страницы уже занят'
            ], 422);
        }
        $exists = Community::where('name', $request->name)->exists();
        if ($exists) {
            return response()->json([
                'code' => 4,
                'error' => 'Название уже занято'
            ], 422);
        }
        $user = $request->user('api');
        $community = new Community;
        $community->fill($request->input());
        $community->save();
        if ($community->type == 2) {
            $community->profile_nursery = new CommunityProfileNursery;
            $community->profile_nursery->community_id = $community->id;
            $community->profile_nursery->fill($request->input());
            $community->profile_nursery->save();
        }
        if ($community->type == 4) {
            $community->profile_breed = new CommunityProfileBreed;
            $community->profile_breed->community_id = $community->id;
            $community->profile_breed->fill($request->input());
            $community->profile_breed->save();
        }
        if (in_array($community->type, [1, 2])) {
            $member = new CommunityMember;
            $member->community_id = $community->id;
            $member->user_id = $user->id;
            $member->save();
        }
        if (in_array($community->type, [3, 4])) {
            $like = new Like;
            $like->object_id = $community->id;
            $like->object_type = 'community';
            $like->user_id = $user->id;
            $like->save();
        }
        $role = new CommunityRole;
        $role->community_id = $community->id;
        $role->user_id = $user->id;
        $role->role = 1;
        $role->save();
        return $community;
    }

    /**
     * @param Request $request
     * @param $slug
     * @return array|Builder|Model|object|null
     */
    public function show(Request $request, $slug)
    {
        $user = $request->user('api');
        $query = Community::query();
        if (ctype_digit($slug)) {
            $query->where('id', $slug);
        } else {
            $query->where('slug', $slug);
        }
        $community = $query->first();
        $community->append([
            'cover',
            'user_role'
        ]);
        if ($community->type == 2) {
            $community->load([
                'profile_nursery',
                'profile_nursery.owner:user_id,slug,name'
            ]);
        }
        if ($community->type == 4) {
            $community->load('profile_breed');
        }
        if ($request->reason == 'show') {
            $joined = false;
            $liked = false;
            $subscribed = false;
            $community->load([
                'linked_communities',
                'linked_users',
                'linked_users.user'
            ]);
            $community->loadCount([
                'photos' => function ($query) {
                    $query->withoutGlobalScopes();
                },
                'roles'
            ]);
            $community->append('top_photos');
            if (in_array($community->type, [1, 2])) {
                $community->loadCount('members');
                $community->append('top_members');
                if ($user) {
                    $joined = $community->memberships()->where('user_id', $user->id)->count() > 0;
                }
            }
            if (in_array($community->type, [3, 4])) {
                $community->loadCount('likes');
                $community->append('top_likers');
                if ($user) {
                    $liked = $community->likes()->where('user_id', $user->id)->exists();
                }
            }
            if ($community->type == 2) {
                $community->loadCount([
                    'pets',
                    'graduates'
                ]);
                $community->append([
                    'top_pets',
                    'top_graduates'
                ]);
            }
            if ($user) {
                $subscribed = $user->user_subscriptions()->where('wall_id', $community->id)->where('wall_type', 'community')->count() > 0;
            }
            $community->toArray();
            return [
                'community' => $community,
                'flags' => [
                    'joined' => $joined,
                    'liked' => $liked,
                    'subscribed' => $subscribed
                ]
            ];
        }

        return $community;
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
        $community = Community::find($id);
        if ($request->slug != $community->slug) {
            if (in_array(strtolower($request->slug), Community::RESERVED_SLUGS)) {
                return response()->json([
                    'code' => 1,
                    'error' => 'Невозможно использовать указанный адрес страницы'
                ], 422);
            }
            if (!preg_match('/^[a-z0-9_]+$/i', $request->slug)) {
                return response()->json([
                    'code' => 2,
                    'error' => 'Адрес страницы может содержать только латинские буквы, цифры, и символ подчеркивания'
                ], 422);
            }
            $exists = Community::where('slug', $request->slug)->exists();
            if ($exists) {
                return response()->json([
                    'code' => 3,
                    'error' => 'Адрес страницы уже занят'
                ], 422);
            }
        }
        if ($request->name != $community->name) {
            $exists = Community::where('name', $request->name)->exists();
            if ($exists) {
                return response()->json([
                    'code' => 4,
                    'error' => 'Название уже занято'
                ], 422);
            }
        }
        $community->fill($request->input());
        $community->save();
        if ($community->type == 2) {
            if (!$community->profile_nursery) {
                $community->profile_nursery = new CommunityProfileNursery;
                $community->profile_nursery->community_id = $community->id;
            }
            $community->profile_nursery->fill($request->input());
            $community->profile_nursery->save();
        }
        if ($community->type == 4) {
            if (!$community->profile_breed) {
                $community->profile_breed = new CommunityProfileBreed;
                $community->profile_breed->community_id = $community->id;
            }
            $community->profile_breed->fill($request->input());
            $community->profile_breed->save();
        }
        return $community;
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        //
    }

//    /**
//     * @param Request $request
//     * @param $id
//     * @return JsonResponse
//     */
//    public function join(Request $request, $id)
//    {
//        $user = $request->user();
//        $membership = new CommunityMember;
//        $membership->community_id = $id;
//        $membership->user_id = $user->id;
//        $membership->save();
//        return response()->json(null, 200);
//    }

//    /**
//     * @param Request $request
//     * @param $id
//     * @return JsonResponse
//     */
//    public function leave(Request $request, $id)
//    {
//        $user = $request->user();
//        CommunityMember::where('community_id', $id)
//                       ->where('user_id', $user->id)
//                       ->delete();
//        return response()->json(null, 200);
//    }
}

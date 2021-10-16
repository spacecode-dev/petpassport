<?php

namespace App\PetPassport\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Models\User\UserFriend;
use App\PetPassport\Models\PetProfile;
use App\PetPassport\Models\Community\CommunityMember;
use App\PetPassport\Models\Like;
use Illuminate\Http\Response;

class ProfilesController extends Controller
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
            $user = $request->user('api');
            $query = UserProfile::query();
            if ($request->type) {
                $query->where('type', $request->type);
            }
            if ($request->types) {
                $query->whereIn('type', explode(',', $request->types));
            }
            if ($request->gender) {
                $query->where('gender', $request->gender);
            }
            if ($request->mating) {
                if ($user) {
                    $query->where('user_id', '!=', $user->id);
                }
                $query->where('mating', $request->mating);
                $query->where('memory', false);
            }
            if ($request->age) {
                $from = Carbon::now()->subYears($request->age);
                $to = $from->copy()->subYear();
                $query->where('birthday', '<', $from);
                $query->where('birthday', '>', $to);
                //$query->whereYear('birthday', $year);
            }
            if ($request->country_id) {
                $query->where('country_id', $request->country_id);
            }
            if ($request->city_id) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->pets_count) {
                $c = explode('-', $request->pets_count);
                if (isset($c[0]) && $c[0]) {
                    $query->has('pets', '>=', $c[0]);
                }
                if (isset($c[1]) && $c[1]) {
                    $query->has('pets', '<=', $c[1]);
                }
            }
            if ($request->pet_type) {
                if ($request->types == 3) {
                    $query->whereHas('pet_profile', function ($query) use ($request) {
                        $query->where('pet_type', $request->pet_type);
                    });
                } else {
                    $query->whereHas('pet_profiles', function ($query) use ($request) {
                        $query->where('pet_type', $request->pet_type);
                    });
                }
            }
            if ($request->nursery_id) {
                $query->whereHas('pet_profile', function ($query) use ($request) {
                    $query->where('nursery_id', $request->nursery_id);
                });
            }
            if ($request->born_nursery_id) {
                $query->whereHas('pet_profile', function ($query) use ($request) {
                    $query->where('born_nursery_id', $request->born_nursery_id);
                });
            }
            if ($request->q) {
                $s = explode('/', urldecode($request->q));
                $s = end($s);
                $query->where(function ($query) use ($s) {
                    $query->where('slug', $s);
                    if (ctype_digit($s)) {
                        $query->orWhere('user_id', $s);
                    }
                    $query->orWhere('name', 'ilike', '%' . $s . '%');
                });
            }
            $total = $query->count();
            $profiles = $query->get();
            return [
                'profiles' => $profiles,
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
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param Request $request
     * @param $slug
     * @return JsonResponse
     */
    public function show(Request $request, $slug)
    {
        $reason = $request->get('reason');
        if($reason === 'show') {

            $searchSlug = ['slug' => $slug];
            if (is_numeric($slug)) {
                $searchSlug = [['user_id', '=', $slug], ['slug', '!=', null]];
            }
            $userProfile = UserProfile::where($searchSlug)->withCount([
                'announcements' => function ($query) {
                    $query->withoutGlobalScopes();
                },
                'photos' => function ($query) {
                    $query->withoutGlobalScopes();
                },
                'reviews',
                'shops'
            ])->first();

            if ($userProfile) {
                $userProfile->append([
                    'cover',
                    'top_friends',
                    'top_shops',
                    'top_announcements',
                    'top_reviews',
                    'top_pages',
                    'top_groups',
                    'top_nurseries',
                    'top_photos',
                    'recommended_profiles',
                    'recommended_groups'
                ]);

                if ($userProfile->type == 3) {
                    $userProfile->load([
                        'parents',
                        'childrens'
                    ]);
                    $userProfile->append([
                        'relatives'
                    ]);
                }

                $friends_count = UserFriend::where(function ($query) use ($userProfile) {
                    $query->where('user_id', $userProfile->user_id);
                    $query->orWhere('friend_id', $userProfile->user_id);
                })->where('accepted', true)->count();

                $profile = $userProfile->toArray();

                if ($userProfile->type == 3) {
                    $petProfile = PetProfile::where('user_id', $userProfile->user_id)->first();
                    $petProfile->load([
                        'breeder',
                        'owner',
                        'nursery:id,type,slug,name',
                        'born_nursery:id,type,slug,name'
                    ]);
                    $profile = array_merge($profile, $petProfile->toArray());
                }

                $pages_count = Like::where('object_type', 'community')->where('user_id', $userProfile->user_id)->count();
                $groups_count = CommunityMember::where('user_id', $userProfile->user_id)->whereHas('community', function ($query) {
                    $query->where('type', 1);
                })->count();
                $nurseries_count = CommunityMember::where('user_id', $userProfile->user_id)->whereHas('community', function ($query) {
                    $query->where('type', 2);
                })->count();
                $result = [
                    'profile' => $profile,
                    'counters' => ['pages' => $pages_count, 'friends' => $friends_count, 'groups' => $groups_count, 'nurseries' => $nurseries_count, 'subscribers' => 0],
                    'flags' => ['self' => false, 'friend' => false, 'friendship_incoming' => false, 'friendship_outgoing' => false, 'subscribed' => false]
                ];
                $user = $request->user('api');
                if ($user) {
                    $result['flags']['self'] = $userProfile->user_id == $user->id;
                    if (!$result['flags']['self']) {
                        $friendship = UserFriend::where(function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                            $query->orWhere('friend_id', $user->id);
                        })->where(function ($query) use ($userProfile) {
                            $query->where('user_id', $userProfile->user_id);
                            $query->orWhere('friend_id', $userProfile->user_id);
                        })->first();
                        if ($friendship) {
                            $result['flags']['friend'] = $friendship->accepted;
                            $result['flags']['friendship_incoming'] = $friendship->friend_id == $user->id;
                            $result['flags']['friendship_outgoing'] = $friendship->user_id == $user->id;
                        }
                        $subcount = $user->user_subscriptions()
                            ->where('wall_id', $userProfile->user_id)
                            ->where('wall_type', 'profile')
                            ->count();
                        $result['flags']['subscribed'] = (bool)$subcount;
                    }
                }
                return response()->json($result, 200);
            }
            return response()->json([], 404);
        } else {
            return response()->json([], 200);
        }
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

    /**
     * @param Request $request
     * @param $slug
     * @return Builder|Model|object|null
     */
    public function pedigree(Request $request, $slug)
    {
        //\DB::enableQueryLog();
        $fields = [
            'user_profiles.user_id',
            'name',
            'slug',
            'gender',
            'birthday',
            'mating',
            'memory',
            'country_id',
            'city_id',
            'birth_country_id'
        ];
        $fields_passport = implode(',', [
            'user_id',
            'colour'
        ]);
        $level = 7;
        $query = UserProfile::query();
        $query->with('passport:' . $fields_passport, 'pet_profile');
        $query->select($fields);
        if (ctype_digit($slug)) {
            $query->where('user_id', $slug);
        } else {
            $query->where('slug', $slug);
        }
        $fields_string = implode(',', $fields);
        for ($i = 1; $i <= $level; $i++) {
            $parents = implode('.', array_fill(0, $i, 'parents'));
            $query->with($parents . ':' . $fields_string);
            $passport = $parents . '.passport:' . $fields_passport;
            $query->with($passport);
            $pet_profile = $parents . '.pet_profile';
            $query->with($pet_profile);
        }
        //dd(\DB::getQueryLog());
        return $query->first();
    }

    /**
     * @param Request $request
     * @param $slug
     * @return Builder|Model|object|null
     */
    public function passport(Request $request, $slug)
    {
        $query = UserProfile::query();
        if (ctype_digit($slug)) {
            $query->where('user_id', $slug);
        } else {
            $query->where('slug', $slug);
        }
        $query->with(
            'owners:user_profiles.user_id,slug,name,phone',
            'passport',
            'drugs',
            'parturitions'
        );
        return $query->first();
    }

    /**
     * @param Request $request
     * @param $slug
     * @return Builder|Model|object|null
     */
    public function card(Request $request, $slug)
    {
        $query = UserProfile::query();
        if (ctype_digit($slug)) {
            $query->where('user_id', $slug);
        } else {
            $query->where('slug', $slug);
        }
        $query->with(
            'owners:user_profiles.user_id,slug,name',
            'passport',
            'pet_profile',
            'parents:user_profiles.user_id,slug,name,gender',
            'childrens:user_profiles.user_id,slug,name,gender'
        );
        $profile = $query->first();
        $profile->append([
            'relatives'
        ]);
        return $profile;
    }
}

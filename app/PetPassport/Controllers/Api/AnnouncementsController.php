<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Announcement\Announcement;
use App\PetPassport\Models\Like;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Models\Localization\Country;
use App\PetPassport\Models\Localization\City;
use App\PetPassport\Models\MarketCategory;

class AnnouncementsController extends Controller
{
    /**
     * @param Request $request
     * @return array|Builder[]|Collection|JsonResponse
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 20;
        if ($request->reason == 'liked') {
            $user = $request->user('api');
            if (!$user) {
                return response()->json(null, 403);
            }
            $likes = Like::where('object_type', 'announcement')->where('user_id', $user->id)->get();
            $ids = $likes->pluck('object_id');
            $announcements = [];
            if (count($ids)) {
                $announcements = Announcement::with('photos')->whereIn('id', $ids)->get();
            }
            return $announcements;
        }
        if ($request->reason == 'search') {
            $simpleSearchBy = [
                'country_id',
                'city_id',
                'owner_id',
                'owner_type'
            ];
            $query = Announcement::query();
            $query->with('photo');
            foreach ($simpleSearchBy as $col) {
                if ($request->input($col)) {
                    $query->where($col, $request->input($col));
                }
            }
            if ($request->price_from) {
                $query->where('price', '>=', $request->price_from);
            }
            if ($request->price_to) {
                $query->where('price', '<=', $request->price_to);
            }
            if (($request->price_from || $request->price_to) && $request->currency) {
                $query->where('currency', $request->currency);
            }
            if ($request->gender) {
                $query->whereIn('id', function ($q) use ($request) {
                    $q->select('announcement_id')->from('announcement_pets');

                    if ($request->gender) {
                        $q->where('gender', $request->gender);
                    }
                });
                //$query->where('gender', $request->gender);
            }
            if ($request->category_id) {
                $category = MarketCategory::find($request->category_id);
                $childrens = $category->childrens()->select(['id']);
                $catids = $childrens->get()->pluck('id');
                $catids->push($category->id);
                $query->whereIn('category_id', $catids);
            }
            if ($request->q) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'ilike', '%' . $request->q . '%');
                    $query->orWhereHas('category', function ($query) use ($request) {
                        if ($request->category_id) {
                            $query->where('parent_id', $request->category_id);
                        }
                        $query->where('name', 'ilike', '%' . $request->q . '%');
                    });
                });
            }
            if (!$request->order) {
                $query->orderByRaw('CASE WHEN pinned_until > NOW() THEN created_at END DESC');
                $query->orderBy('created_at', 'desc');
            }
            if ($request->order == 'price-asc') {
                $query->orderBy('price', 'asc');
            }
            if ($request->order == 'price-desc') {
                $query->orderBy('price', 'desc');
            }
            $total = $query->count();
            $query->skip($offset);
            $query->take($limit);
            $announcements = $query->get();
            $result = [
                'announcements' => $announcements,
                'total' => $total
            ];
            if (isset($category)) {
                $cats = [];
                if ($announcements->count()) {
                    if (!$category->parent_id) {
                        $cats_query = $category->childrens();
                    } else {
                        $cats_query = $category->siblings();
                    }
                    $cats_query->whereHas('announcements', function ($query) use ($request) {
                        $query->where('owner_id', $request->owner_id);
                        $query->where('owner_type', $request->owner_type);
                    });
                    $cats = $cats_query->get();
                }
                $result['categories'] = $cats;
            }
            return $result;
        }
        if ($request->reason == 'popular') {
            $query = Announcement::with('photo');
            $query->where('views_today', '>', 0);
            $query->orderBy('views_today', 'desc');
            $total = $query->count();
            $query->skip($offset);
            $query->take($limit);
            $announcements = $query->get();
            return [
                'announcements' => $announcements,
                'total' => $total
            ];
        }
        if ($request->reason == 'aside') {
            $query = Announcement::query();
            $query->with('photo');
            $query->where('id', '!=', $request->announcement_id);
            if ($request->liked) {
                $user = $request->user('api');
                $query->whereHas('likes', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            }
            if ($request->similar) {
                $ann = Announcement::find($request->announcement_id);
                $query->where('category_id', $ann->category_id);
                $query->where('country_id', $ann->country_id);
                $query->where('city_id', $ann->city_id);
                if ($ann->type == 1) {
                    $query->whereHas('announcement_pet', function ($query) use ($ann) {
                        $query->where('gender', $ann->announcement_pet->gender);
                        $query->where('pedigree', $ann->announcement_pet->pedigree);
                    });
                }
            }
            if ($request->popular) {
                $query->orderBy('views_today', 'desc');
            }
            $query->limit(10);
            $announcements = $query->get();
            return $announcements;
        }
        if ($request->reason == 'owner') {
            $query = Announcement::query();
            $query->with('photo');
            $query->where('owner_id', $request->owner_id);
            $query->where('owner_type', $request->owner_type);
            if (!$request->order) {
                //$query->orderByRaw('CASE WHEN pinned_until > NOW() THEN created_at END DESC');
                //$query->orderBy('created_at', 'desc');
                $query->orderBy('id', 'desc');
            }
            if ($request->order == 'price-asc') {
                $query->orderBy('price', 'asc');
            }
            if ($request->order == 'price-desc') {
                $query->orderBy('price', 'desc');
            }
            $total = $query->count();
            $query->skip($offset);
            $query->take($limit);
            $announcements = $query->get();
            return [
                'announcements' => $announcements,
                'total' => $total
            ];
        }
        if ($request->reason == 'favorites') {
            $query = Like::query();
            $query->with([
                'object',
                'object.photo'
            ]);
            $query->where('user_id', $request->owner_id);
            $query->where('object_type', 'announcement');
            if (!$request->order) {
                //$query->orderByRaw('CASE WHEN pinned_until > NOW() THEN created_at END DESC');
                //$query->orderBy('created_at', 'desc');
                $query->orderBy('id', 'desc');
            }
            $total = $query->count();
            $query->skip($offset);
            $query->take($limit);
            $announcements = $query->get()->map(function ($item) {
                return $item->object;
            });
            return [
                'announcements' => $announcements,
                'total' => $total
            ];
        }
    }

    /**
     *
     */
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
     * @param $id
     * @return array
     */
    public function show(Request $request, $id)
    {
        $user = $request->user('api');
        $announcement = Announcement::with('owner', 'photos')->find($id);
        $announcement->increment('views');
        $announcement->increment('views_today');
        $announcement->owner->append('stars');
        if ($announcement->owner_type == 'profile') {
            $announcement->owner->setVisible([
                'user_id',
                'name',
                'phone',
                'avatar',
                'rating',
                'link',
                'stars',
                'created_at'
            ]);
        }
        if ($announcement->owner_type == 'shop') {
            $announcement->owner->setVisible([
                'name',
                'avatar',
                'link',
                'stars',
                'created_at'
            ]);
        }
        $announcement->append('can_edit');
        $ann = $announcement->toArray();
        $pet = null;
        if (true) {
            $ann = array_merge($ann, $announcement->announcement_pet->toArray());
            $pet_id = $announcement->announcement_pet->pet_id;
            if ($pet_id) {
                $pet = UserProfile::where('user_id', $pet_id)->first();
            }
        }
        $lang = 'ru';
        if ($announcement->country_id) {
            $ann['country'] = Country::with(['localized' => function ($query) use ($lang) {
                $query->where('lang', $lang);
            }])->find($announcement->country_id);
        }
        if ($announcement->city_id) {
            $ann['city'] = City::with(['localized' => function ($query) use ($lang) {
                $query->where('lang', $lang);
            }])->find($announcement->city_id);
        }
        $liked = false;
        if ($user) {
            $liked = Like::where('object_id', $announcement->id)
                ->where('object_type', 'announcement')
                ->where('user_id', $user->id)
                ->exists();
        }

//        $similar = Announcement::with('announcement_pet', 'photo')
//                               ->where('id', '!=', $announcement->id)
//                               ->where('category_id', $announcement->category_id)
//                               ->where('country_id', $announcement->country_id)
//                               ->where('city_id', $announcement->city_id);
//
//        if ($announcement->type == 1) {
//            $similar->whereHas('announcement_pet', function($query) use ($announcement) {
//                $query->where('gender', $announcement->announcement_pet->gender);
//                $query->where('pedigree', $announcement->announcement_pet->pedigree);
//            });
//        }
//
//        $similar->inRandomOrder();
//        $similar->limit(10);
//        $similar = $similar->get();

        $popular = Announcement::with('announcement_pet', 'photo')
            ->where('id', '!=', $announcement->id)
            ->orderBy('views_today', 'desc')
            ->limit(30)
            ->get();

        if ($popular->count() > 5) {
            $popular = $popular->random(5);
        } else {
            $popular = $popular->shuffle();
        }
        return [
            'announcement' => $ann,
            //'creator' => $announcement->creator->append('stars'),
            'pet' => $pet,
            'popular' => $popular
        ];
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

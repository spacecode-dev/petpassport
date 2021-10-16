<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\Review;

class ReviewsController extends Controller
{
    /**
     * @param Request $request
     * @return Builder[]|Collection
     */
    public function index(Request $request)
    {
        $query = Review::query();
        $query->with('user');
        $query->where('owner_id', $request->owner_id);
        $query->where('owner_type', $request->owner_type);
        $query->orderBy('id', 'desc');
        return $query->get();
    }

    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return Review|JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user('api');
        if ($request->owner_type == 'profile' && $request->owner_id == $user->id) {
            return response()->json([
                'code' => 1,
                'error' => 'Невозможно добавить отзыв самому себе'
            ], 422);
        }
        if (!$request->stars) {
            return response()->json([
                'code' => 2,
                'error' => 'Вы не поставили оценку'
            ], 422);
        }
        $query = Review::query();
        $query->where('owner_id', $request->owner_id);
        $query->where('owner_type', $request->owner_type);
        $query->where('user_id', $user->id);
        $count = $query->count();
        if ($count) {
            return response()->json([
                'code' => 3,
                'error' => 'Вы уже оставляли отзыв для этого пользователя'
            ], 422);
        }
        $review = new Review;
        $review->fill($request->input());
        $review->user_id = $user->id;
        $review->save();
        if ($review->owner_type == 'profile') {
            if ($review->stars == 1) {
                $review->owner()->decrement('rating', 300);
            }
            if ($review->stars == 2) {
                $review->owner()->decrement('rating', 100);
            }
            if ($review->stars == 4) {
                $review->owner()->increment('rating', 100);
            }
            if ($review->stars == 5) {
                $review->owner()->increment('rating', 300);
            }
        }
        $review->owner->append('stars');
        return $review;
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
     */
    public function destroy($id)
    {
        //
    }
}

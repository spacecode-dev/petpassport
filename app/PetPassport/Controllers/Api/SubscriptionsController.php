<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserSubscription;
use App\PetPassport\Models\User\UserProfile;

class SubscriptionsController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 15;
        $query = UserSubscription::query();
        $query->with('wall');
        $query->where('user_id', $request->user_id);
        if ($request->wall_type) {
            $query->where('wall_type', $request->wall_type);
        }
        if ($request->q) {
            $query->whereHasMorph('wall', [UserProfile::class], function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request->q . '%');
            });
        }
        if (!$request->order || $request->order == 'created_at-desc') {
            $query->orderBy('created_at', 'desc');
        }
        if ($request->order == 'created_at-asc') {
            $query->orderBy('created_at', 'asc');
        }
        $total = $query->count();
        $query->skip($offset);
        $query->take($limit);
        $subscriptions = $query->get();
        return [
            'subscriptions' => $subscriptions,
            'total' => $total
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function subscribers(Request $request)
    {
        $offset = $request->offset ?? 0;
        $limit = ($request->limit && intval($request->limit) <= 100) ? $request->limit : 15;
        $query = UserSubscription::query();
        $query->where('wall_id', $request->wall_id);
        $query->where('wall_type', $request->wall_type);
        if ($request->q) {
            $query->whereHas('subscriber', function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request->q . '%');
            });
        }
        if (!$request->order || $request->order == 'created_at-desc') {
            $query->orderBy('created_at', 'desc');
        }
        if ($request->order == 'created_at-asc') {
            $query->orderBy('created_at', 'asc');
        }
        $total = $query->count();
        $query->with('subscriber');
        $query->skip($offset);
        $query->take($limit);
        $subs = $query->get();
        $users = $subs->pluck('subscriber');
        return [
            'subscribers' => $users,
            'total' => $total
        ];
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribers_destroy(Request $request)
    {
        // TODO: permission check
        UserSubscription::where('user_id', $request->user_id)
            ->where('wall_id', $request->wall_id)
            ->where('wall_type', $request->wall_type)
            ->delete();

        return response()->json(null, 200);
    }
}

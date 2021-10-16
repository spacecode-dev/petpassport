<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserSubscription;

class UserSubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user();
        UserSubscription::firstOrCreate([
            'user_id' => $user->id,
            'wall_id' => $request->wall_id,
            'wall_type' => $request->wall_type
        ]);
        return response()->json(null, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        UserSubscription::where('user_id', $request->user()->id)
            ->where('wall_id', $request->wall_id)
            ->where('wall_type', $request->wall_type)
            ->delete();
        return response()->json(null, 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy_subscriber(Request $request)
    {
        UserSubscription::where('user_id', $request->user_id)
            ->where('wall_id', $request->user()->id)
            ->where('wall_type', 'profile')
            ->delete();
        return response()->json(null, 200);
    }
}

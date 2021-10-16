<?php

namespace App\PetPassport\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    use AuthenticatesUsers, ValidatesRequests;

    /**
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        $request->user()->token()->delete();
        return response()->json([], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $user = User::where('login', $request->get('login'))->first();
        if ($user) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $this->clearLoginAttempts($request);
            return response()->json([
                'token' => $token
            ], 200);
        }
        return response()->json([], 422);
    }
}

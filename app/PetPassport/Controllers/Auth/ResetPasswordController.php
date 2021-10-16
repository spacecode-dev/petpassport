<?php

namespace App\PetPassport\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    use ValidatesRequests, ResetsPasswords;

    /**
     * ResetPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * @param Request $request
     * @param null $token
     * @return Factory|View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('profile.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->get('email')]
        );
    }
}

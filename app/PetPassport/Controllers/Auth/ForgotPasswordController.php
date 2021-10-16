<?php

namespace App\PetPassport\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{

    use ValidatesRequests, SendsPasswordResetEmails;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->middleware('petpassport:guest');

//        ResetPassword::toMailUsing(function ($notifiable, $token) {
//            return (new MailMessage)
//                ->subject(__('Reset Password Notification'))
//                ->line(__('You are receiving this email because we received a password reset request for your account.'))
//                ->action(__('Reset Password'), url(config('petpassport.path').route('petpassport.password.reset', $token, false)))
//                ->line(__('If you did not request a password reset, no further action is required.'));
//        });
    }

    /**
     * @return Factory|Response|View
     */
    public function showLinkRequestForm()
    {
        return view('profile.auth.passwords.email');
    }

//    /**
//     * Get the broker to be used during password reset.
//     *
//     * @return PasswordBroker
//     */
//    public function broker()
//    {
//        return Password::broker(config('petpassport.passwords'));
//    }
}

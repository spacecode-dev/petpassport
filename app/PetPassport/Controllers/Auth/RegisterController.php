<?php

namespace App\PetPassport\Controllers\Auth;

use App\PetPassport\Models\PetProfile;
use App\PetPassport\Models\User\User;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Requests\Auth\RegisterRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var User
     */
    private $user;

    /**
     * @var UserProfile
     */
    private $userProfile;

    /**
     * @var PetProfile
     */
    private $petProfile;

    /**
     * @return string
     */
    public function redirectPath()
    {
        return request()->get('login');
    }

    /**
     * @param User $user
     * @param UserProfile $userProfile
     * @param PetProfile $petProfile
     */
    public function __construct(User $user, UserProfile $userProfile, PetProfile $petProfile)
    {
        $this->user = $user;
        $this->petProfile = $petProfile;
        $this->userProfile = $userProfile;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->all();
        $user = $this->create($data);

        $this->userProfile->user_id = $user->id;
        $this->userProfile->type = $data['type'];
        $this->userProfile->name = $user->name;
        $this->userProfile->slug = $user->login;
        $this->userProfile->save();

        if ($this->userProfile->type === 3) {
            $this->petProfile->user_id = $user->id;
            $this->petProfile->name = $user->name;
            $this->petProfile->pet_type = $data['pet_type'];
            $this->petProfile->save();
        }

        if ($user) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json([
                'token' => $token
            ], 200);
        }

        return response()->json([], 422);
    }

    /**
     * @param array $data
     * @return User
     * @throws \Exception
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'created_at' => new Carbon,
            'updated_at' => new Carbon
        ]);
    }
}

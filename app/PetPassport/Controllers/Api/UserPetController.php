<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\User;
use App\PetPassport\Models\PetProfile;
use App\PetPassport\Models\User\UserPet;
use App\PetPassport\Models\User\UserProfile;

class UserPetController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $pets = $request->user()->pets()->with('pet_profile')->get()->toArray();
        foreach ($pets as &$pet) {
            $pet = array_merge($pet, $pet['pet_profile']);
            unset($pet['pet_profile']);
        }
        return $pets;
    }

    /**
     * @param Request $request
     * @return array|JsonResponse
     */
    public function store(Request $request)
    {
        if (in_array(strtolower($request->login), User::RESERVED_LOGINS)) {
            return response()->json([
                'code' => 1,
                'error' => 'Невозможно использовать указанный логин'
            ], 422);
        }
        if (!preg_match('/^[a-z0-9_]+$/i', $request->login)) {
            return response()->json([
                'code' => 2,
                'error' => 'Логин может содержать только латинские буквы, цифры, и символ подчеркивания'
            ], 422);
        }
        $count = User::where('login', $request->login)->count();
        if ($count) {
            return response()->json([
                'code' => 3,
                'error' => 'Логин уже занят'
            ], 422);
        }
        $data = $request->input();
//        $data = $request->validate([
//            'name'     => 'required',
//            'login'    => 'required|unique:users|max:255',
//            'password' => 'required',
//            'type'     => 'integer|nullable',
//            'gender'   => 'integer|nullable',
//            'memory'   => 'boolean|nullable'
//        ]);
        $user = $request->user();
        $pet = new User;
        $pet->login = $data['login'];
        $pet->email = $data['login'] . '@users.petpassport.online';
        $pet->password = bcrypt($data['password']);
        $pet->save();
        $profile = new UserProfile;
        $profile->fill($data);
        $profile->user_id = $pet->id;
        $profile->type = 3;
        $profile->slug = $pet->login;
        $profile->save();
        $petProfile = new PetProfile;
        $petProfile->fill($data);
        $petProfile->user_id = $pet->id;
        $petProfile->breeder_id = $user->id;
        $petProfile->save();
        $userPet = new UserPet;
        $userPet->user_id = $user->id;
        $userPet->pet_id = $pet->id;
        $userPet->save();
        $request->user()->profile()->increment('rating', 2000);
        $profile->refresh();
        $petProfile->refresh();
        return array_merge(
            $profile->toArray(),
            $petProfile->toArray()
        );
    }

    /**
     * @param $id
     */
    public function show($id)
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
     * @param $id
     * @return JsonResponse
     */
    public function login(Request $request, $id)
    {
        $count = $request->user()->user_pets()->where('pet_id', $id)->count();
        if (!$count) return response()->json(null, 403);
        $pet = User::find($id);
        $token = $pet->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login_owner(Request $request)
    {
        $ownership = UserPet::where('pet_id', $request->user()->id)->first();
        if (!$ownership) return response()->json(null, 403);
        $owner = User::find($ownership->user_id);
        $token = $owner->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function link(Request $request)
    {
        $user = $request->user();
        $account = User::where('login', $request->login)->first();
        if (!$account || !Hash::check($request->password, $account->password)) {
            return response()->json([
                'code' => 1,
                'error' => 'Неверный логин или пароль'
            ], 422);
        }
        if ($account->profile->type != 3) {
            return response()->json([
                'code' => 2,
                'error' => 'Данный аккаунт не является аккаунтом питомца'
            ], 422);
        }
        $ownership = UserPet::where('pet_id', $account->id)->first();
        if ($ownership && $ownership->user_id == $user->id) {
            return response()->json([
                'code' => 3,
                'error' => 'Данный питомец уже прикреплен к Вашему аккаунту'
            ], 422);
        }
        UserPet::where('pet_id', $account->id)->delete();
        $ownership = new UserPet;
        $ownership->user_id = $user->id;
        $ownership->pet_id = $account->id;
        $ownership->save();
        return $account->merged_profile;
    }
}

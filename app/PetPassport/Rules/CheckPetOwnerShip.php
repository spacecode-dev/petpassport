<?php

namespace App\PetPassport\Rules;

use App\PetPassport\Models\User\User;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CheckPetOwnerShip implements Rule
{
    /**
     * @var User
     */
    private $user;

    /**
     * CheckPetOwnerShip constructor.
     */
    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }
        $user = $this->user->find(Auth::id());
        $user->load('pets');
        return !$user->pets->where('user_id', '=', $value)->isEmpty();
    }

    /**
     * @return array|Translator|string|null
     */
    public function message()
    {
        return trans('validation.announcements_pet_id');
    }
}

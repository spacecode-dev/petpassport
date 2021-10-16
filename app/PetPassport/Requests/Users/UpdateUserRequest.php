<?php

namespace App\PetPassport\Requests\Users;

use App\PetPassport\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        $reservedLogins = collect(User::RESERVED_LOGINS)->push(Auth::user()['login'])->toArray();
        return [
            'login' => ['sometimes', 'min:3', 'max:255', 'regex:/^[a-z0-9_]+$/i', 'regex:/^[a-z0-9_]+$/i', 'unique:users,login,NULL,id,deleted_at,NULL' . Auth::id(), Rule::notIn($reservedLogins)],
            'email' => ['sometimes', 'email:rfc,dns', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL' . Auth::id()],
            'password' => ['sometimes', 'min:6', 'confirmed'],
            'current_password' => [
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('Неверный текущий пароль'));
                    }
                }
            ],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'login.unique' => 'Логин уже занят',
            'login.not_in' => 'Невозможно использовать указанный логин',
            'email.unique'  => 'Почта уже занята',
            'login.regex'  => 'Логин может содержать только латинские буквы, цифры, и символ подчеркивания',
            'password.confirmed'  => 'Пароль не совпадает с подтверждением',
        ];
    }
}

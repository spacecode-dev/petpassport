<?php

namespace App\PetPassport\Requests\Auth;

use App\PetPassport\Models\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        $type = $this->request->get('type');
        if($type !== '3') {
            return [
                'login' => ['required', 'min:3', 'max:255', 'regex:/^[a-z0-9_]+$/i', 'regex:/^(?=.*[a-zA-Z]).+$/', 'unique:users,login,NULL,id,deleted_at,NULL', Rule::notIn(User::RESERVED_LOGINS)],
                'email' => ['required', 'email:rfc,dns', 'max:255'],
                'password' => ['required', 'string', 'min:6', 'max:60', 'confirmed'],
                'type' => ['required',  'exists:user_types,id'],
                'name' => ['required', 'min:3', 'max:100']
            ];
        } elseif ($type === '3') {
            return [
                'login' => ['required', 'min:3', 'max:255', 'regex:/^[a-z0-9_]+$/i', 'regex:/^(?=.*[a-zA-Z]).+$/', 'unique:users,login,NULL,id,deleted_at,NULL', Rule::notIn(User::RESERVED_LOGINS)],
                'password' => ['required', 'string', 'min:6', 'max:60', 'confirmed'],
                'pet_type' => ['required',  'exists:market_categories,id'],
                'name' => ['required', 'min:3', 'max:100'],
            ];
        }
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'login.unique' => 'Логин уже занят',
            'login.not_in' => 'Невозможно использовать указанный логин',
            'email.unique'  => 'Почта уже занята',
            'login.regex'  => 'Логин может содержать только латинские буквы, цифры, и символ подчеркивания. Должна быть как минимум одна буква',
        ];
    }
}

<?php

namespace App\PetPassport\Requests\Announcements;

use App\PetPassport\Models\Gender;
use App\Rules\CheckPetOwnerShip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserAnnouncementRequest extends FormRequest
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
        return [
            'category_id' => ['required', 'exists:market_categories,id'],
            'title' => ['required', 'min:15', 'max:255'],
            'description' => ['required','min:10', 'max:1000'],
            'price' => ['required', 'numeric', 'between:0.10,1000000.00'],
            'currency' => ['required', 'exists:currencies,id'],
            'gender' => ['required', Rule::in(array_keys(Gender::LIST))],
            'pet_id' => ['sometimes', new CheckPetOwnerShip()],
            'country_id' => ['required', 'exists:countries,id'],
            'city_id' =>  ['required', 'exists:cities,id' ],
            'birthday' => ['required', 'date', 'before_or_equal:now']
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        //TODO write a translation
        return [
            'category_id.required' => 'Категория обязательна к заполнению',
            'category_id.exists' => 'Данной категории не существует',
            'login.not_in' => 'Невозможно использовать указанный логин',
            'email.unique'  => 'Почта уже занята',
            'login.regex'  => 'Логин может содержать только латинские буквы, цифры, и символ подчеркивания',
            'country_id.required' => 'Выберите страну',
            'city_id.required' => 'Выберите город'
        ];
    }
}

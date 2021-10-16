<?php

namespace App\PetPassport\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
//            'category_id' => ''
        ];
    }
}

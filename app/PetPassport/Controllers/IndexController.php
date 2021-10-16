<?php

namespace App\PetPassport\Controllers;

use App\PetPassport\Models\MarketCategory;
use App\PetPassport\Models\User\User;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Models\User\UserType;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View as ViewShare;
use Illuminate\View\View;

class IndexController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $data = collect();
        $data->put('userTypes', (new UserType)->getWithTranslate());
//        $data->put('petCategories', (new MarketCategory)->getPetCategories());
        ViewShare::share('transferData', json_encode($data->toArray()));
        return view('index.app');
    }
}

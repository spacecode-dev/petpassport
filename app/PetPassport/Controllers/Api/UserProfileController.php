<?php

namespace App\PetPassport\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\PetPassport\Models\User\UserParent;
use App\PetPassport\Models\Drug;
use App\PetPassport\Models\Parturition;
use App\PetPassport\Models\Passport;

class UserProfileController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        if ($user->profile->type === 3) {
            $profile->load([
                'parents'
            ]);
            $user->pet_profile->load([
                'owner',
                'breeder'
            ]);
            $profile = collect($profile)->merge($user->pet_profile->toArray())->toArray();
        }
        return $profile;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $user = $request->user();
        // TODO PROFILE VALIDATION $request
        $user->profile->fill($request->input());
        $user->profile->save();

        if($request->has('name')) {
            $user->fill(['name' => $request->input('name')]);
            $user->save();
        }
//        if ($user->profile->type == 3) {
//            $user->pet_profile->fill($request->input());
//            $user->pet_profile->save();
//        }
//        if ($request->has('parents')) {
//            UserParent::where('user_id', $user->id)->delete();
//            $ids = explode(',', $request->parents);
//            foreach ($ids as $id) {
//                $parent = new UserParent;
//                $parent->user_id = $user->id;
//                $parent->parent_id = $id;
//                $parent->save();
//                //todo mass requests optimization
//            }
//        }
//        if ($request->has('drugs')) {
//            Drug::where('user_id', $user->id)->delete();
//            $drugs = json_decode($request->drugs, true);
//            foreach ($drugs as $drug) {
//                $clone = $drug;
//                unset($clone['type']);
//                unset($clone['user_id']);
//                if (!array_filter($clone)) continue;
//                $d = new Drug;
//                $d->user_id = $user->id;
//                $d->fill($drug);
//                $d->save();
//            }
//        }
//        if ($request->has('parturitions')) {
//            Parturition::where('user_id', $user->id)->delete();
//            $parturitions = json_decode($request->parturitions, true);
//            foreach ($parturitions as $parturition) {
//                $clone = $parturition;
//                unset($clone['user_id']);
//                if (!array_filter($clone)) continue;
//                $p = new Parturition;
//                $p->user_id = $user->id;
//                $p->fill($parturition);
//                $p->save();
//            }
//        }
//        if ($request->has('passport')) {
//            $data = json_decode($request->passport, true);
//            $passport = Passport::firstOrNew([
//                'user_id' => $user->id
//            ]);
//            $passport->user_id = $user->id;
//            $passport->fill($data);
//            $passport->save();
//        }
//        return $user;
        return response()->json(['user' => $user, 'message' => 'Успешное обновление'], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $profile = $request->user()->profile;
        if ($request->hasFile('avatar')) {
            $upload = $request->file('avatar');
            $crop = json_decode($request->avatar_crop);
            $ext = $upload->getClientOriginalExtension();
            $image = Image::make($upload->getRealPath());
            $image->crop($crop->width, $crop->height, $crop->x, $crop->y);
            $image->resize(500, 500);
            $stream = $image->stream($ext);
            $filename = 'public/avatars/' . Str::random(40) . '.' . $ext;
            Storage::put($filename, $stream);
            $profile->avatar = Storage::url($filename);
        }
        if ($request->hasFile('background')) {
            $upload = $request->file('background');
            $crop = json_decode($request->background_crop);
            $ext = $upload->getClientOriginalExtension();
            $image = Image::make($upload->getRealPath());
            $image->crop($crop->width, $crop->height, $crop->x, $crop->y);
            $stream = $image->stream($ext);
            $filename = 'public/backgrounds/' . Str::random(40) . '.' . $ext;
            Storage::put($filename, $stream);
            $profile->background = Storage::url($filename);
        }
        $profile->save();
        return response()->json($profile->merged_profile);
    }
}

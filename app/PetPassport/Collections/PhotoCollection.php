<?php

namespace App\PetPassport\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\PetPassport\Models\Like;

class PhotoCollection extends Collection
{

    /**
     * @return array
     */
    public function liked()
    {
        $user_id = auth('api')->id();
        $ids = $this->pluck('id')->toArray();
        $liked = [];
        if (count($ids)) {
            $liked = Like::whereIn('object_id', $ids)
                ->where('object_type', 'photo')
                ->where('user_id', $user_id)
                ->get()
                ->pluck('object_id')
                ->toArray();
        }
        return $liked;
    }
}

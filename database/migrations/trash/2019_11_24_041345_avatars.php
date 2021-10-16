<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Photo;
use App\Models\UserProfile;

class Avatars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = UserProfile::query();
        $query->whereNotNull('avatar');
        $query->orWhereNotNull('background');

        $profiles = $query->get();

        foreach ($profiles as $profile) {
            $avatar = $profile->getOriginal('avatar');

            if ($avatar) {
                $a = new Photo;
                $a->section = Photo::SECTIONS['avatar'];
                $a->owner_id = $profile->user_id;
                $a->owner_type = 'profile';
                $a->original = $avatar;
                $a->original_width = 0;
                $a->original_height = 0;
                $a->save();
            }

            $background = $profile->getOriginal('background');

            if ($background) {
                $b = new Photo;
                $b->section = Photo::SECTIONS['cover'];
                $b->owner_id = $profile->user_id;
                $b->owner_type = 'profile';
                $b->original = $background;
                $b->original_width = 0;
                $b->original_height = 0;
                $b->save();
            }
        }

        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('background');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

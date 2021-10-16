<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\UserProfile;

class AddHomeNameToPetProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->string('home_name')->nullable()->after('user_id');
        });

        $profiles = UserProfile::where('type', 3)->get();

        foreach ($profiles as $profile) {
            $profile->pet_profile->home_name = $profile->name;
            $profile->pet_profile->save();
            if ($profile->pet_profile->official_name) {
                $profile->name = $profile->pet_profile->official_name;
                $profile->save();
            }
        }

        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->dropColumn('official_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('pet_profiles', function (Blueprint $table) {
            //
        });
        */
    }
}

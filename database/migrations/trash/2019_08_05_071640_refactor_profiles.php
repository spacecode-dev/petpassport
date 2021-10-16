<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;
use App\Models\UserProfile;
use App\Models\PetProfile;

class RefactorProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->nullable()->after('user_id');
            $table->string('slug')->nullable()->unique()->after('type');
            $table->boolean('memory')->default(false)->after('verified');
        });

        $users = User::all();

        foreach ($users as $user) {
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            if ($user_profile) {
                $user_profile->type = $user->type;
                $user_profile->slug = $user->login;
                $user_profile->save();
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        $pet_profiles = PetProfile::with('user')->get();

        foreach ($pet_profiles as $pet_profile) {
            $user_profile = new UserProfile;
            $user_profile->user_id = $pet_profile->user_id;
            $user_profile->type = 3;
            $user_profile->slug = $pet_profile->user->login;
            $user_profile->name = $pet_profile->name;
            $user_profile->gender = $pet_profile->gender;
            $user_profile->birthday = $pet_profile->birthday;
            $user_profile->avatar = $pet_profile->avatar;
            $user_profile->background = $pet_profile->background;
            $user_profile->about = $pet_profile->about;
            $user_profile->site = $pet_profile->site;
            $user_profile->verified = $pet_profile->verified;
            $user_profile->memory = $pet_profile->memory;
            $user_profile->created_at = $pet_profile->created_at;
            $user_profile->updated_at = $pet_profile->updated_at;
            $user_profile->save();
        }

        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('gender');
            $table->dropColumn('birthday');
            $table->dropColumn('avatar');
            $table->dropColumn('background');
            $table->dropColumn('about');
            $table->dropColumn('site');
            $table->dropColumn('verified');
            $table->dropColumn('memory');
            $table->renameColumn('type', 'pet_type');
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

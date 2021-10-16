<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;
use App\Models\UserProfile;
use App\Models\PetProfile;

class RefactorUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = User::all();
        foreach ($users as $user) {
            $profile = $user->type == 3 ? new PetProfile : new UserProfile;
            $profile->user_id = $user->id;
            $profile->name = $user->name;
            $profile->verified = $user->verified;
            $profile->save();
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('verified');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\UserProfile;
use App\Models\PetProfile;

class AddMatingColumnToUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->boolean('mating')->default(false)->after('verified');
        });

        $pets = PetProfile::where('mating', true)->get();

        foreach ($pets as $pet) {
            UserProfile::where('user_id', $pet->user_id)->update([
                'mating' => '1'
            ]);
        }

        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->dropColumn('mating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}

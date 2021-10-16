<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreederToPetProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('breeder_id')->nullable()->after('user_id');
        });

        $ownerships = \DB::table('user_pets')->get();

        foreach ($ownerships as $ownership) {
            \DB::table('pet_profiles')->where('user_id', $ownership->pet_id)->update([
                'breeder_id' => $ownership->user_id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->dropColumn('breeder_id');
        });
    }
}

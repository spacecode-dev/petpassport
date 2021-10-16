<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOwnerIdToPetProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable()->after('breeder_id');
        });

        $ownerships = \DB::table('user_pets')->get();

        foreach ($ownerships as $ownership) {
            \DB::table('pet_profiles')->where('user_id', $ownership->pet_id)->update([
                'owner_id' => $ownership->user_id
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
            $table->dropColumn('owner_id');
        });
    }
}

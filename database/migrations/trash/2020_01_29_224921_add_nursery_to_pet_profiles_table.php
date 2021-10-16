<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNurseryToPetProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('nursery_id')->nullable()->after('breeder_id');
            $table->unsignedBigInteger('born_nursery_id')->nullable()->after('nursery_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pet_profiles', function (Blueprint $table) {
            $table->dropColumn('nursery_id');
            $table->dropColumn('born_nursery_id');
        });
    }
}

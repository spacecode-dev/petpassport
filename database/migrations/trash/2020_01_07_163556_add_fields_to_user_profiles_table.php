<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->after('rating');
            $table->unsignedBigInteger('city_id')->nullable()->after('country_id');
            $table->unsignedBigInteger('birth_country_id')->nullable()->after('city_id');
            $table->string('work_name')->nullable()->after('birth_country_id');
            $table->string('work_place')->nullable()->after('work_name');
            $table->string('edu_name')->nullable()->after('work_place');
            $table->string('edu_group')->nullable()->after('edu_name');
            $table->string('edu_degree')->nullable()->after('edu_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            //
        });
    }
}

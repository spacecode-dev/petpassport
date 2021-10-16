<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('chip_number')->nullable();
            $table->string('localization')->nullable();
            $table->date('chip_date')->nullable();
            $table->string('vet_name')->nullable();
            $table->string('certificate')->nullable();
            $table->string('dnk')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('reg_clinic')->nullable();
            $table->string('reg_journal_number')->nullable();
            $table->date('reg_date')->nullable();
            $table->string('reg_vet_name')->nullable();
            $table->string('breed')->nullable();
            $table->string('colour')->nullable();
            $table->string('dist_marks')->nullable();
            $table->string('animal_card_number')->nullable();
            $table->string('pedigree_number')->nullable();
            $table->string('tag_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passports');
    }
}

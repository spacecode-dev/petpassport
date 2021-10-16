<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Community;
use App\Models\CommunityRole;

class CreateCommunityRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('community_members', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::create('community_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('community_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('role')->default(0);
            $table->timestamps();
        });

        $communities = Community::get();

        foreach ($communities as $community) {
            $role = new CommunityRole;
            $role->community_id = $community->id;
            $role->user_id = $community->user_id;
            $role->role = CommunityRole::ROLES['owner'];
            $role->save();
        }

        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_roles');
    }
}

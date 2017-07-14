<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Models\RelationUserRole;

class AlterUsersTable5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(User::all() as $user) {
            $role = new RelationUserRole();
            $role->user_id = $user->id;
            $role->role_id = $user->role_id;
            $role->save();
        }
        
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table)
        {
            $table->integer('role_id')->unsigned()->nullable();
        });
    }
}

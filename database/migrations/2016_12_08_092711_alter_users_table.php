<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('role_id')->unsigned()->after('id');
            // $table->foreign('role_id')->references('id')->on('roles');
            $table->string('api_key')->after('password')->nullable();
            $table->string('new_email')->after('email')->nullable();
            $table->string('phone')->after('new_email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            // $table->dropForeign('users_role_id_foreign');
            $table->dropColumn('role_id');
            $table->dropColumn('api_key');
            $table->dropColumn('new_email');
            $table->dropColumn('phone');
        });
    }
}

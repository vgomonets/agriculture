<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->integer('user_group_id')->unsigned()->nullable()->after('ext_id');
            $table->integer('individual_id')->unsigned()->nullable()->after('user_group_id');
            $table->string('full_name')->after('name');
        });

        // $table->foreign('individual_id')->references('id')->on('individuals');

        exec("mysql -u " . env('DB_USERNAME', 'forge') . " -p".env('DB_PASSWORD', '')
            . " " . env('DB_DATABASE', 'forge') . " < " . database_path()
            . '/dump/2016_12_21_124537_alter_users_table3.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('user_group_id');
            $table->dropColumn('full_name');
            $table->dropColumn('individual_id');
        });
        // DB::statement("DROP PROCEDURE IF EXISTS `add_user`");
    }
}

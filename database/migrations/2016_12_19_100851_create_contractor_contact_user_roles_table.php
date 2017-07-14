<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorContactUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_contact_user_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();
            $table->string('name');
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_19_100851_create_contractor_contact_user_roles_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contractor_contact_user_roles');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_contractor_contact_user_role`");
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorContactUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_contact_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();
            $table->integer('contractor_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->enum('type', ['worker', 'private']);
            $table->string('phone');
            $table->string('phone2');
            $table->string('email');
            $table->string('address');
            $table->string('position');
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_19_100852_create_contractor_contact_users_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contractor_contact_users');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_contractor_contact_user`");
    }
}

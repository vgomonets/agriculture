<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('parent_ext_id')->nullable();
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_19_083224_create_contractor_groups_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contractor_groups');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_contractor_group`");
    }
}

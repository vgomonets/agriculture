<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individuals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();
            $table->string('name');
            $table->timestamps();
        });
        exec("mysql -u " . env('DB_USERNAME', 'forge') . " -p".env('DB_PASSWORD', '')
            . " " . env('DB_DATABASE', 'forge') . " < " . database_path()
            . '/dump/2016_12_21_122718_create_individuals_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('individuals');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_individual`");
    }
}

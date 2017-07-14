<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id');
            $table->integer('region_id')->unsigned()->nullable();
            $table->string('name');
            $table->timestamps();
        });

        // $table->foreign('region_id')->references('id')->on('regions');

        exec("mysql -u " . env('DB_USERNAME', 'forge') . " -p".env('DB_PASSWORD', '')
            . " " . env('DB_DATABASE', 'forge') . " < " . database_path()
            . '/dump/2016_12_21_133337_create_cities_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cities');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_city`");
    }
}

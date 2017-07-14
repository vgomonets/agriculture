<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id');
            $table->integer('user_id')->unsigned();
            $table->string('zip_code');
            $table->integer('region_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('district');
            $table->string('locality');
            $table->string('street');
            $table->string('house');
            $table->string('housing');
            $table->string('flat');
            $table->timestamps();
        });

        // $table->foreign('user_id')->references('id')->on('users');
        // $table->foreign('region_id')->references('id')->on('regions');
        // $table->foreign('city_id')->references('id')->on('cities');

        exec("mysql -u " . env('DB_USERNAME', 'forge') . " -p".env('DB_PASSWORD', '')
            . " " . env('DB_DATABASE', 'forge') . " < " . database_path()
            . '/dump/2016_12_21_133338_create_addresses_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('addresses');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_address`");
    }
}

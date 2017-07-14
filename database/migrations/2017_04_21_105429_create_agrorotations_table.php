<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrorotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agrorotations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('agroculture_id')->unsigned()->nullable();
            $table->integer('chemical_id')->unsigned()->nullable();
            $table->integer('unit_id')->unsigned()->nullable();
            $table->float('price')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agrorotations');
    }
}

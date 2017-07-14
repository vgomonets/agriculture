<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationNomenclaturaUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_nomenclaturas_units', function (Blueprint $table) {
            $table->integer('nomenclatura_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->integer('coefficient')->float();
            $table->timestamps();
            $table->softDeletes();
            $table->primary(['nomenclatura_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relation_nomenclaturas_units');
    }
}

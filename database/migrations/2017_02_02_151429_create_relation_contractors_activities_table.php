<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationContractorsActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_contractors_activities', function (Blueprint $table) {
            $table->integer('contractor_id')->unsigned();
            $table->integer('contractor_activity_id')->unsigned();
            $table->primary(['contractor_id', 'contractor_activity_id'], 'contractor_activity_key');
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
        Schema::drop('relation_contractors_activities');
    }
}

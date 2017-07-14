<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationContractorContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_contractor_contractors', function (Blueprint $table) {
            $table->integer('parent_contractor_id')->unsigned();
            $table->integer('contractor_id')->unsigned();
            $table->string('position')->nullable();
            $table->primary(['parent_contractor_id', 'contractor_id'], 'key_contractor_contractor');
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
        Schema::drop('relation_contractor_contractors');
    }
    
}

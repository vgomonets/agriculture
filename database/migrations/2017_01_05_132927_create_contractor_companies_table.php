<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_contractors_companies', function (Blueprint $table) {
            $table->integer('contractor_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->primary(['contractor_id', 'company_id']);
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
        Schema::drop('relation_contractors_companies');
    }
}

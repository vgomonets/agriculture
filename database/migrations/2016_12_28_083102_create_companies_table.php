<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();
            $table->boolean('is_buyer')->nullable();
            $table->boolean('is_supplier')->nullable();
            $table->boolean('is_not_residend')->nullable();
            $table->integer('contractor_group_id')->unsigned()->nullable();
            $table->integer('contractor_activity_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('inn')->nullable();
            $table->string('code_egrpou')->nullable();
            $table->string('number_vat')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('companies');
    }
}

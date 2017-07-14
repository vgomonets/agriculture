<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id')->nullable();
            $table->string('ext_id')->nullable();
            $table->boolean('is_buyer')->nullable();
            $table->boolean('is_supplier')->nullable();
            $table->boolean('is_not_residend')->nullable();
            $table->integer('contractor_group_id')->nullable();
            $table->integer('contractor_activity_id')->nullable();
            $table->string('name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('inn')->nullable();
            $table->string('code_egrpou')->nullable();
            $table->string('number_vat')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->float('square')->nullable();
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
        Schema::drop('companies_histories');
    }
}

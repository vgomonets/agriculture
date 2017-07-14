<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterTableRelationContractorsCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relation_contractors_companies', function (Blueprint $table) {
            $table->string('position')->nullable();
        });
        
        Schema::drop('contractor_contact_users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relation_contractors_companies', function (Blueprint $table) {
            $table->dropColumn('position');
        });
        
        Schema::create('contractor_contact_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();
            $table->integer('contractor_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->enum('type', ['worker', 'private']);
            $table->string('phone');
            $table->string('phone2');
            $table->string('email');
            $table->string('address');
            $table->string('position');
            $table->timestamps();
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationUserContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_user_contractors', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('contractor_id');
            $table->timestamps();
            $table->primary(['user_id', 'contractor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relation_user_contractors');
    }
}

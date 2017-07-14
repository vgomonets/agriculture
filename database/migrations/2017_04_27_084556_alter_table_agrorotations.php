<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAgrorotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agrorotations', function (Blueprint $table) {
            $table->integer('number')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('seller')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agrorotations', function(Blueprint $table)
        {
            $table->dropColumn('number');
            $table->dropColumn('name');
            $table->dropColumn('seller');
        });
    }
}

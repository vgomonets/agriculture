<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSquareToCompaniesAndAgrorotations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agrorotations', function (Blueprint $table) {
            $table->float('square')->unsigned()->nullable()->after('id');
        });
        
        Schema::table('companies', function (Blueprint $table) {
            $table->float('square')->unsigned()->nullable();
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
            $table->dropColumn('square');
        });
        
        Schema::table('companies', function(Blueprint $table)
        {
            $table->dropColumn('square');
        });
    }
}

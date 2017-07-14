<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelationContractorCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
   {
       Schema::table('relation_contractors_companies', function (Blueprint $table) {
           $table->string('disided')->nullable();
       });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relation_contractors_companies', function (Blueprint $table) {
            $table->dropColumn('disided');
        });
    }
}

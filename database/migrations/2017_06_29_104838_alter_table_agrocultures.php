<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAgrocultures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agrocultures', function(Blueprint $table)
        {
            $table->integer('company_id')->nullable()->unsigned()->after('id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agrocultures', function(Blueprint $table)
        {
            $table->dropForeign('agrocultures_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
}

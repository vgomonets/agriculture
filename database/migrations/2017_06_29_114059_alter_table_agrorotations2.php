<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAgrorotations2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agrorotations', function(Blueprint $table)
        {
            $table->dropColumn('date');
            $table->integer('agrorotation_date_id')
                    ->nullable()
                    ->unsigned()
                    ->after('id');
            $table->foreign('agrorotation_date_id')
                    ->references('id')
                    ->on('agrorotation_dates')
                    ->onDelete('cascade');
            $table->foreign('company_id')
                    ->references('id')
                    ->on('companies')
                    ->onDelete('cascade');
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
            $table->date('date');
            $table->dropForeign('agrorotations_agrorotation_date_id_foreign');
            $table->dropForeign('agrorotations_company_id_foreign');
            $table->dropColumn('agrorotation_date_id');  
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_16_110914_create_units_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('units');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_unit`");
    }
}

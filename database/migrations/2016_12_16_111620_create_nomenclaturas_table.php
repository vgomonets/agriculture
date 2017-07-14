<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNomenclaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'nomenclaturas',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('ext_id')->unique();
                $table->integer('nomenclatura_group_id')->unsigned();
                $table->integer('nomenclatura_type_id')->unsigned();
                $table->string('customs_declaration')->nullable();
                $table->string('name');
                $table->string('full_name');
                $table->integer('vat_id')->unsigned();
                $table->timestamps();
            }
        );
        exec("mysql -u " . env('DB_USERNAME', 'forge')
        ." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < "
        . database_path(). '/dump/2016_12_16_111620_create_nomenclaturas_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nomenclaturas');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_nomenclatura`");
    }
}

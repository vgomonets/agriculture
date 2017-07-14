<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNomenclaturaPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomenclatura_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nomenclatura_price_type_id')->unsigned();
            $table->integer('nomenclatura_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->date('date')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2017_02_02_085153_create_nomenclatura_prices_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nomenclatura_prices');
    }
}

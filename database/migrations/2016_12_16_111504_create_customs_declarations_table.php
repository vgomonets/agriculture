<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomsDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs_declarations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->unique();
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_16_111504_create_customs_declarations_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customs_declarations');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_customs_declaration`");
    }
}

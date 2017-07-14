<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractorContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ext_id')->nullable();

            $table->integer('contact_id')->unsigned();
            $table->integer('contractor_id')->unsigned();
            $table->string('contact_type');

            $table->string('delivery_addr')->nullable();
            $table->string('legal_addr')->nullable();
            $table->string('actual_addr')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            // $table->foreign('contractors_id')->references('id')->on('contractors');
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_19_090653_create_contractor_contacts_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contractor_contacts');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_contractor_contact`");
    }
}

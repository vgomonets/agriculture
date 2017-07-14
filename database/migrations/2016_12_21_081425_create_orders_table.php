<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Заказы
 */
class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_pay_type_id')->unsigned();
            $table->integer('contractor_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('order_status_id')->unsigned();
            $table->boolean('is_approved');
            $table->softDeletes();
            $table->timestamps();
        });
        exec("mysql -u ".env('DB_USERNAME', 'forge')." -p".env('DB_PASSWORD', '')." ".env('DB_DATABASE', 'forge')." < " . database_path(). '/dump/2016_12_21_081425_create_orders_table.sql');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
        // DB::statement("DROP PROCEDURE IF EXISTS `add_order`");
    }
}

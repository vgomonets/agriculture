<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Vat;

class CreateVatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'vats',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('value');
                $table->timestamps();
            }
        );

        $vat = new Vat();
            $vat->value = '20%';
            $vat->save();
        $vat = new Vat();
            $vat->value = 'Без НДС';
            $vat->save();
        $vat = new Vat();
            $vat->value = 'Не НДС';
            $vat->save();
        $vat = new Vat();
            $vat->value = '0%';
            $vat->save();
        $vat = new Vat();
            $vat->value = '7%';
            $vat->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vats');
    }
}

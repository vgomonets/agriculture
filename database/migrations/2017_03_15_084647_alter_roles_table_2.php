<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRolesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->integer('parent_role_id')->nullable()->after('id');
            $table->boolean('disabled');
        });
        
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin',
            'title' => 'Администратор',
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'parent_role_id' => 1,
            'name' => 'head',
            'title' => 'Руководитель (Коммерческий директор)',
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'vip manager',
            'title' => 'Вип менеджер',
            'disabled' => 1,
        ]);
        DB::table('roles')->insert([
            'id' => 4,
            'parent_role_id' => 5,
            'name' => 'manager',
            'title' => 'Менеджер',
        ]);
        DB::table('roles')->insert([
            'id' => 5,
            'parent_role_id' => 2,
            'name' => 'regional head',
            'title' => 'Региональный директор',
        ]);
        DB::table('roles')->insert([
            'id' => 6,
            'name' => 'lawyer',
            'title' => 'Юрист',
            'disabled' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('parent_role_id');
            $table->dropColumn('disabled');
        });
    }
}

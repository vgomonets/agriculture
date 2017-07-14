<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class TaskGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_groups')->insert([
            'name' => 'Тестовая группа1',
        ]);
        DB::table('task_groups')->insert([
            'name' => 'Тестовая группа1',
        ]);
    }
}

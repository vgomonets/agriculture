<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class TaskTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_templates')->insert([
            'group_id' => 1,
            'title' => 'Тестовая задача',
            'description' => 'Тестовое описание',
            'priority' => 'normal',
            'executor_role_id' => 1,
            'contractor_required' => 1,
            'day_limit' => 5,
            'creator_id' => 1,
        ]);
        DB::table('task_templates')->insert([
            'group_id' => 2,
            'title' => 'Тестовая задача2',
            'description' => 'Тестовое описание2',
            'priority' => 'low',
            'executor_role_id' => 2,
            'contractor_required' => 0,
            'day_limit' => 5,
            'creator_id' => 1,
        ]);
        DB::table('task_templates')->insert([
            'group_id' => 1,
            'title' => 'Тестовая задача3',
            'description' => 'Тестовое описание3',
            'priority' => 'high',
            'executor_role_id' => 3,
            'contractor_required' => 1,
            'day_limit' => 10,
            'creator_id' => 1,
        ]);
    }
}

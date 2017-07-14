<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class ContractorActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contractor_activities')->insert([
            'name' => 'test activity1',
            'created_at' => date('Y-m-d', time()),
            'updated_at' => date('Y-m-d', time()),
        ]);
        DB::table('contractor_activities')->insert([
            'name' => 'test activity2',
            'created_at' => date('Y-m-d', time()),
            'updated_at' => date('Y-m-d', time()),
        ]);
    }
}

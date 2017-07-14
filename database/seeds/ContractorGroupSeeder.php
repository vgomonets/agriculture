<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class ContractorGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contractor_groups')->insert([
            'ext_id' => 'test ext_id1',
            'name' => 'test group1',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        DB::table('contractor_groups')->insert([
            'ext_id' => 'test ext_id2',
            'name' => 'test group2',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}

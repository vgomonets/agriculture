<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'ext_id' => 'test ext_id1',
            'name' => 'test region1',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        DB::table('regions')->insert([
            'ext_id' => 'test ext_id2',
            'name' => 'test region2',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}

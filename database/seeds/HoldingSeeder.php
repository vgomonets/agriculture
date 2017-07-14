<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class HoldingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('holdings')->insert([
            'name' => 'test holding',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        DB::table('holdings')->insert([
            'name' => 'test holding 2',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }
}

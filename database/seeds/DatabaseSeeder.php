<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(HoldingSeeder::class);
        $this->call(ContractorGroupSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(ContractorActivitySeeder::class);
        $this->call(ContractorActivitySeeder::class);
        $this->call(TaskGroupSeeder::class);
        //$this->call(TaskTemplateSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ContractorSeeder::class);
    }
}

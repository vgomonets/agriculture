<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admins
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@agroservice.ua',
            'password' => bcrypt('Agroculture2016!!!!'),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        DB::table('users')->insert([
            'name' => '1c',
            'email' => '1c@agroservice.ua',
            'password' => bcrypt('9wzY0QQn1ZkR'),
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        
        DB::table('relation_user_roles')->insert([
            'user_id' => 1,
            'role_id' => 1,   // admin
        ]);
        DB::table('relation_user_roles')->insert([
            'user_id' => 2,
            'role_id' => 4,   // manager
        ]);
    }
}

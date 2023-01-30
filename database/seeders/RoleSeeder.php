<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private  array $roles =
        [
            ['name'=>'admin'],
            ['name'=>'user']
        ];

    public function run()
    {
        DB::table('roles')->insert($this->roles);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {
         Room::factory(25)->create();

        $this->call([
                RoleSeeder::class,
                AdminSeeder::class,
        ]);

    }
}

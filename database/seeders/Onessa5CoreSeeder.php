<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Onessa5CoreSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(SiteLayoutSeeder::class);
        $this->call(PagesSeeder::class);
    }
}

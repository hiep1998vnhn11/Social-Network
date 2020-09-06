<?php

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
        //Hello cac
        $this->call(SSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ChatSeeder::class);
    }
}

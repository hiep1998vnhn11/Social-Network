<?php

use Illuminate\Database\Seeder;
use App\Models\Chat;
use Illuminate\Support\Str;
use App\Models\Room;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 3; $i <= 13; $i++){
            Room::create([
                'user_id' => $i,
                'with_id' => $i+1,
            ]);

            Room::create([
                'user_id' => $i+1,
                'with_id' => $i,
            ]);
        }
    }
}

<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $role = Role::findById(1);
        for($i; $i<=10; $i++){
            $user = Factory(App\User::class)->create([
                'name' => Str::random(6),
                'email' => 'bot'.$i.'@gmail.com',
                'password' => bcrypt('123456'),
                'url' => Str::random(12),
            ]);
            $user->assignRole($role);
            $post = App\Post::create([
                'user_id' => $user->id,
                'content' => Str::random(6) . ' ' . Str::random(5),
                'visible' => 'public',
            ]);
            $like = App\Like::create([
                'post_id' => $post->id,
                'user_id' => $i,
            ]);
            $comment = App\Comment::create([
                'post_id' => $post->id,
                'user_id' => $i,
                'content' => Str::random(6) . ' ' . Str::random(5) . Str::random(6) . ' ' . Str::random(5)
            ]);
        };

        for($j=1;$j<=10;$j++){
            for($i=1;$i<=100;$i++){
                App\Message::create([
                    'sent_id' => $j,
                    'received_id' => $j+1,
                    'content' => Str::random(5)
                ]);
            }
        }
    }
}

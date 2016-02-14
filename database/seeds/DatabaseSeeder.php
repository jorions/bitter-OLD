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
        factory(App\User::class, 50)->create()->each(function($user) {

            // Each user will create 5 posts
            for ($i=0; $i<5; $i++) {
                $user->posts()->save(factory(App\Post::class)->make());
            }

            // Each user will favorite 2 posts
            for ($i=0; $i<2; $i++) {

                // Store a random post_id
                $temp = rand(1, App\Post::all()->count());

                // If the loop has not run before assigned a value to $lastTemp
                if ($i == 0) {
                    $lastTemp = 0;
                }

                // To prevent overlap, keep generating a new random post_id until a new post_id is generated
                while ($temp == $lastTemp) {
                    $temp = rand(1, App\Post::all()->count());
                }

                // Now that a new post_id has been generated, favorite the post
                $user->likes()->attach($temp);

                // Store the post_id to be rechecked in case the loop runs again
                $lastTemp = $temp;
            }

        });
    }
}

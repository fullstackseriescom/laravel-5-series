<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Post;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(User::class, 5)->create()->each(function($u) {
        if ($u->id == 1) {
          $u->assignRole('administrator');
        } else {
          $u->assignRole('user');
        }
      });
      factory(Post::class, 8)->create(['user_id'=>1]);
    }
}

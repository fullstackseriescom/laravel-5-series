<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_posts_can_be_created()
    {
        $user = factory(\App\User::class)->create();

        $post = $user->posts()->create([
            'title' => 'Test title',
            'body' => 'Body test'
        ]);

        // $found_post = Post::find(1);
        // $this->assertEquals($found_post->test, 'Test title');

        $this->assertDatabaseHas('posts', ['id' => 1, 'title' => 'Test title']);
    }

    /** @test */
    public function post_can_be_created_by_unlogged_user()
    {
        $response = $this->call('POST', '/posts');
        $this->assertEquals(403, $response->status());
    }

}

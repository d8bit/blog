<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{

    use DatabaseTransactions;

    public function testGetPosts()
    {
        $response = $this->get('/posts');
        $response->assertStatus(200);
    }

    public function testUpdatePost()
    {
        $post = \App\Models\Post::inRandomOrder()->first();
        $response = $this->json(
            'PUT',
            '/posts/'.$post->id,
            $post->toArray()
        );
        $response->assertStatus(200);
    }

    public function testCreatePost()
    {
        $post = factory(App\Models\Post::class)
            ->make()
            ->each(function ($post) {
                $post->translations()->save(factory(App\Models\PostTranslation::class)->make());
            });

        $response = $this->json(
            'POST',
            '/posts',
            $post->toArray()
        );
        $response->assertStatus(200);
    }

    public function testDeleletePost()
    {
        $post = \App\Models\Post::inRandomOrder()->first();
        $response = $this->delete('/posts/'.$post->id);
        $response->assertStatus(200);
    }

    public function testFailDeleletePost()
    {
        $response = $this->delete('/posts/a');
        $response->assertStatus(400);
    }

}


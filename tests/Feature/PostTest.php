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

    public function testDeleletePost()
    {
        $post = \App\Models\Post::inRandomOrder()->first();
        $response = $this->delete('/posts/'.$post->id);
        $response->assertStatus(200);
    }

}


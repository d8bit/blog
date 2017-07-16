<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Post;

class ExampleTest extends TestCase
{

    public function testPostList()
    {
        $post = new Post();
        $post->all();
        $this->assertTrue(true);
    }

    public function testFind()
    {
        $post = new Post();
        $post = $post->where('image', '<>', '')->first();
        $date = $post->date;
        $image = $post->image;
        $post = $post->where('image', '')->first();
        $image = $post->image;
        $this->assertTrue(true);
    }

    public function testAccessors()
    {
        $post = new Post();

        $post = $post->where('image', '<>', '')->first();
        $image = $post->image;
        $this->assertTrue(strpos($image, 'storage') !== false);

        $post = $post->where('image', '')->first();
        $image = $post->image;
        $this->assertTrue($image == '');

        $date = $post->date;
        $this->assertTrue(true);
    }

    public function testTranslationsRelation()
    {
        $post = new Post();
        $post->first();
        $post->load('translations');
        // $this->assertInstanceOf($post->translations, Collection::class);
    }

    public function testTranslationsScope()
    {
        $post = new Post();
        $post->translated()->first();
        $this->assertTrue(true);
    }

    public function testGetLanguage()
    {
        $post = new Post();
        $post = $post->first();
        $post->load('translations');
        $translation = $post->translations->first();
        $lang = $translation->language;
        $this->assertTrue(true);
    }

}

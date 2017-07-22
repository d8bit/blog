<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Post::class, 5)->create()->each(function ($post) {
            $languages = \App\Models\Language::all();
            foreach ($languages as $language) {
                $translation = factory(App\Models\PostTranslation::class)->make();
                $translation->language_id = $language->id;
                $post->translations()->save($translation);
            }
        });
    }
}

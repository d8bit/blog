<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = factory(App\Models\Language::class, 2)->make();
        foreach ($languages as $language) {
            $language->save();
        }
        $language = factory(App\Models\Language::class)->make();
        $language->default = true;
        $language->save();
    }
}

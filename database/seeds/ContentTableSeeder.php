<?php

use App\Content;
use Illuminate\Database\Seeder;

class ContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Content::class, 50)->create()->each(function ($content) {
            $content->image = 'https://picsum.photos/600/400/?random&dummyParam=' . $content->id;
            $content->save();
        });
    }
}

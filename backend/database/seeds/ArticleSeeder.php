<?php

use Illuminate\Database\Seeder;
use App\Entities\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class, 5)->create();
    }
}

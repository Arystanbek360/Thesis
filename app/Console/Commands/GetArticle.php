<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use Goutte\Client;
use Illuminate\Console\Command;

class GetArticle extends Command
{
    protected $signature = 'app:get-article';

    protected $description = 'Get article from category';

    public function handle()
    {
        $client = new Client();

        foreach (Category::all() as $category) {
            $crawler = $client->request('GET', $category->url);

//            if ($category->id == 2) {
//                dd([
//                    'category'    => $category,
////                'title'       => $title,
//                    'category_id' => $category->id,
////                'url'         => $link,
//                ]);
//            }

            $crawler->filter(
                'a.article-preview-mixed article-preview-mixed--secondary article-preview-mixed--with-absolute-secondary-item'
            )->each(function ($node) use ($category) {
                $link = $node->attr('href');

                $title = $node->filter('h3.preview-title preview-title--medium')->text();

                Article::create([
                    'title'       => $title,
                    'category_id' => $category->id,
                    'url'         => $link,
                ]);

                echo "Название статьи: " . trim($title) . ", Ссылка: $link\n";
            });


            $crawler->filter(
                'a.article-preview-category__content'
            )->each(function ($node) use ($category) {
                $link = $node->attr('href');

                $title = $node->filter('h2.article-preview-category__subhead')->text();


                Article::create([
                    'title'       => $title,
                    'category_id' => $category->id,
                    'url'         => $link,
                ]);

                echo "Название статьи: " . trim($title) . ", Ссылка: $link\n";
            });

            $crawler->filter(
                '.article-preview-mixed.article-preview-mixed--secondary.article-preview-mixed--with-absolute-secondary-item'
            )
                ->each(function ($node) use ($category) {
                    $link = $node->filter('a')->attr('href');

                    $title = $node->filter('.preview-title.preview-title--medium')->text();

                    Article::create([
                        'title'       => $title,
                        'category_id' => $category->id,
                        'url'         => $link,
                    ]);

                    echo "Название статьи: " . trim($title) . ", Ссылка: $link\n";
                });
        }
    }
}

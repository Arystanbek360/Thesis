<?php

namespace App\Console\Commands;

use App\Models\Category;
use Goutte\Client;
use Illuminate\Console\Command;

class GetCategory extends Command
{
    protected $signature = 'app:get-category';

    protected $description = 'Get Category';

    public function handle()
    {
        $categories = [];
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.nur.kz/');

        $crawler->filter('li.header__main-menu-links-item')->each(function ($node) {
            $title = $node->filter('.header__main-menu-links')->text();
            $link = $node->filter('.header__main-menu-links')->attr('href');

            $categories[] = Category::create([
                'category_id' => null,
                'name' => $title,
                'url' => $link,
            ]);

            echo "Название категории: $title, Ссылка на категорию: $link\n";
        });

        foreach (Category::all() as $category) {
            $crawler = $client->request('GET', $category->url);

            $crawler->filter('li.header__main-menu-links-item')->each(function ($node) use ($category) {
                $link = $node->filter('a.header__main-menu-links--secondary')->attr('href');
                $title = $node->filter('a.header__main-menu-links--secondary')->text();

                Category::create([
                    'category_id' => $category->id,
                    'name' => $title,
                    'url' => $link,
                ]);

                echo "Название: $title, Ссылка: $link\n";
            });
        }
    }
}

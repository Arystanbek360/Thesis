<?php

namespace App\Console\Commands;

use App\Models\Article;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Console\Command;

class GetArticleInfo extends Command
{
    protected $signature = 'app:get-article-info';

    protected $description = 'Get article with author';

    public function handle()
    {
        $client   = new Client();
        $articles = Article::where('id', '>', 5578)->get();

        foreach ($articles as $article) {
            $url = $article->url;

            $crawler = $client->request('GET', $url);

            if ($crawler->filter('.formatted-body__content--wrapper')->count() > 0) {
                $author   = $crawler->filter('address.author-item')->text();
                $author   = trim(str_replace('Автор:', '', $author));
                $imageUrl = $crawler->filter('figure.inline-picture__container img')->attr('src');
                $text     = $crawler->filter('p.formatted-body__paragraph')->each(function ($node) {
                    return $node->text() . "\n"; // Возвращаем текст с символом новой строки в конце
                });

                $fullText = implode("\n", $text); // Используем символ новой строки для склеивания

                $publishedDateTime     = $crawler->filter('time.datetime--publication')->attr('datetime');
                $shortDescription      = $crawler->filter('strong.formatted-body__strong')->text();
                $shortDescriptionClean = preg_replace('/<a.*?>.*?<\/a>/', '', $shortDescription);
                $shortDescriptionClean = strip_tags($shortDescriptionClean);
                $publishedAt           = Carbon::createFromFormat('Y-m-d\TH:i:sP', $publishedDateTime);

                $article->author            = $author;
                $article->description       = $fullText;
                $article->published         = $publishedAt;
                $article->short_description = $shortDescriptionClean;
                $article->save();

                $article->images()->create(['image' => $imageUrl]);

                echo "Статья: " . $article->title . " получила полную информацию\n";
            } else {
                echo "Статья: " . $article->title . ' не найден';
            }
        }
    }
}

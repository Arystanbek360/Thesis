<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Console\Command;

class GetAllArticle extends Command
{
    protected $signature = 'app:get-all-article';

    protected $description = 'Command description';

    public function handle()
    {
        foreach (Category::all() as $category) {
            if ($category->id == 2 || $category->id == 3 || $category->id == 8 || $category->id == 9 || $category->id == 1) {
                continue;
            }

            if ($category->id == 4 || $category->id == 5 || $category->id == 6 || $category->id == 7 || $category->id == 10 ||
                $category->id == 11 || $category->id == 12 || $category->id == 13 || $category->id == 14 || $category->id == 15 ||
                $category->id == 16 || $category->id == 17 || $category->id == 18 || $category->id == 19
            ) {
                continue;
            }

            $nodePath = trim(shell_exec('which node'));
            $command  = $nodePath . ' ' . storage_path('parse.js') . ' ' . escapeshellarg($category->url);
            $output   = shell_exec($command);
            $articles = json_decode($output);

            if (!is_array($articles)) {
                $this->error('Failed to decode JSON output');
                return;
            }

            foreach ($articles as $article) {
                Article::create([
                    'title'       => $article->title,
                    'category_id' => $category->id,
                    'url'         => $article->link,
                ]);

                $this->info('Название статьи: ' . $article->title . ', Ссылка: ' . $article->link);
            }
        }
    }

}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Article;
use Illuminate\Support\Str;



class ScrapeBeyondChatsBlogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:beyondchats';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape oldest BeyondChats blog articles and store them';


    /**
     * Execute the console command.
     */
    
    public function handle()
{
    $this->info('Fetching BeyondChats blogs page...');

    $client = new Client();
    $response = $client->get('https://beyondchats.com/blogs/');
    $html = $response->getBody()->getContents();

    if (empty($html)) {
        $this->error('Failed to fetch blog page.');
        return;
    }

    $crawler = new Crawler($html);

    $links = [];

    $crawler->filter('a')->each(function ($node) use (&$links) {
        $href = $node->attr('href');

        if ($href &&
    str_starts_with($href, 'https://beyondchats.com/blogs/') &&
    !str_contains($href, '/tag/') &&
    !str_contains($href, '/page/')
    ) {
    $links[] = $href;
    }
    });

    $links = array_values(array_unique($links));
    $oldestLinks = array_slice($links, -5);

    $this->info('Scraping and saving 5 oldest articles...');

    foreach ($oldestLinks as $url) {
        $this->info("Scraping: {$url}");

        // Fetch article page
        $articleResponse = $client->get($url);
        $articleHtml = $articleResponse->getBody()->getContents();

        $articleCrawler = new Crawler($articleHtml);

        // Extract title
        $title = $articleCrawler->filter('h1')->count()
            ? trim($articleCrawler->filter('h1')->text())
            : 'Untitled Article';

        // Extract paragraphs
        $content = '';
        $articleCrawler->filter('p')->each(function ($p) use (&$content) {
            $content .= trim($p->text()) . "\n\n";
        });

        if (empty(trim($content))) {
            $this->warn('No content found, skipping...');
            continue;
        }

        // Avoid duplicates
        if (Article::where('source_url', $url)->exists()) {
            $this->warn('Article already exists, skipping...');
            continue;
        }

        if ($title === 'Untitled Article') {
        $this->warn('Invalid article title, skipping...');
        continue;
        }

        // Save to DB
        Article::create([
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'content' => $content,
            'source_url' => $url,
            'type' => 'original',
        ]);

        $this->info('Saved successfully.');
    }

    $this->info('Scraping completed.');
}


}

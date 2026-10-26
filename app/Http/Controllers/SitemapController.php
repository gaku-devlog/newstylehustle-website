<?php

namespace App\Http\Controllers;

use App\Community;
use App\News;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $lastModified = now()->toAtomString();
        $entries = [
            ['/', 'daily', '1.0'],
            ['/about-newstylehustle', 'weekly', '0.8'],
            ['/featured-video', 'weekly', '0.8'],
            ['/news', 'weekly', '0.8'],
        ];

        foreach (News::query()->pluck('news_permalink') as $permalink) {
            $entries[] = ['/news/'.$permalink, 'weekly', '0.8'];
        }

        $entries[] = ['/community', 'weekly', '0.8'];

        foreach (Community::query()->pluck('permalink') as $permalink) {
            $entries[] = ['/community/'.$permalink, 'weekly', '0.8'];
        }

        array_push(
            $entries,
            ['/lesson', 'weekly', '0.8'],
            ['/contact', 'monthly', '0.8'],
            ['/about', 'monthly', '0.8'],
            ['/privacy_policy', 'monthly', '0.8'],
            ['/disclaimer', 'monthly', '0.8'],
        );

        $urls = array_map(
            function (array $entry) use ($lastModified): string {
                [$path, $changeFrequency, $priority] = $entry;
                $location = htmlspecialchars(url($path), ENT_XML1 | ENT_QUOTES, 'UTF-8');

                return <<<XML
                    <url>
                        <loc>{$location}</loc>
                        <lastmod>{$lastModified}</lastmod>
                        <changefreq>{$changeFrequency}</changefreq>
                        <priority>{$priority}</priority>
                    </url>
                XML;
            },
            $entries,
        );

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        $xml .= implode("\n", $urls)."\n";
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}

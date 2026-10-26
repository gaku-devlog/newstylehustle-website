<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testPublicPagesRenderSuccessfully(): void
    {
        $paths = [
            '/',
            '/about-newstylehustle',
            '/news',
            '/community',
            '/lesson',
            '/featured-video',
            '/contact',
            '/privacy_policy',
            '/disclaimer',
            '/about',
            '/communityrep_login',
            '/GcnJBe6DwdsK_register',
            '/password/reset',
            '/sitemap',
            '/sitemap.xml',
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function testCommunityDashboardRequiresAuthentication(): void
    {
        $this->get('/communityrep')->assertRedirect('/communityrep_login');
    }

    public function testSitemapIncludesStaticAndDynamicPages(): void
    {
        \App\Community::create([
            'user_id' => 1,
            'permalink' => 'niigata',
            'name' => '新潟コミュニティ',
            'pref' => '新潟',
        ]);
        \App\News::create([
            'user_id' => 1,
            'news_permalink' => 'sample-news',
            'news_title' => 'サンプルニュース',
            'news_body' => '本文',
        ]);

        $response = $this->get('/sitemap');

        $response
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.url('/').'</loc>', false)
            ->assertSee('<loc>'.url('/community/niigata').'</loc>', false)
            ->assertSee('<loc>'.url('/news/sample-news').'</loc>', false);

        $this->assertNotFalse(simplexml_load_string($response->getContent()));
    }
}

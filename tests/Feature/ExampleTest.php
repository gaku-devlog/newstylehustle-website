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
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function testCommunityDashboardRequiresAuthentication(): void
    {
        $this->get('/communityrep')->assertRedirect('/communityrep_login');
    }
}

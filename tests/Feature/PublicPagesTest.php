<?php

use App\Services\HygraphService;

beforeEach(function () {
    $this->mock(HygraphService::class, function ($mock) {
        $mock->shouldReceive('getNavigation')->andReturn([
            ['id' => '1', 'label' => 'Home', 'url' => '/', 'order' => 1, 'image' => null],
            ['id' => '2', 'label' => 'Blog', 'url' => '/blog', 'order' => 2, 'image' => null],
            ['id' => '3', 'label' => 'Contact', 'url' => '/contact', 'order' => 3, 'image' => null],
        ]);

        $mock->shouldReceive('getPage')->with('home')->andReturn([
            'title' => 'Home',
            'slug' => 'home',
            'content' => ['html' => '<p>Welcome</p>'],
        ]);

        $mock->shouldReceive('getPage')->with('contact')->andReturn([
            'title' => 'Contact',
            'slug' => 'contact',
            'content' => ['html' => '<p>Contact us</p>'],
        ]);

        $mock->shouldReceive('getPage')->with('ai')->andReturn([
            'title' => 'AI',
            'slug' => 'ai',
            'content' => ['html' => '<p>AI content</p>'],
        ]);

        $mock->shouldReceive('getPage')->with('code')->andReturn([
            'title' => 'Code',
            'slug' => 'code',
            'content' => ['html' => '<p>Code content</p>'],
        ]);

        $mock->shouldReceive('getPage')->with('nonexistent')->andReturnNull();

        $mock->shouldReceive('getPosts')->andReturn([
            [
                'title' => 'Test Post',
                'slug' => 'test-post',
                'excerpt' => 'A test post',
                'createdAt' => '2026-01-01T00:00:00Z',
                'author' => ['name' => 'Author', 'picture' => null],
            ],
        ]);

        $mock->shouldReceive('getPost')->with('test-post')->andReturn([
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => ['html' => '<p>Post content</p>'],
            'createdAt' => '2026-01-01T00:00:00Z',
            'author' => ['name' => 'Author', 'bio' => 'A writer', 'picture' => null],
        ]);

        $mock->shouldReceive('getPost')->with('nonexistent')->andReturnNull();
    });
});

it('can view the home page', function () {
    $this->get('/')->assertSuccessful();
});

it('can view the contact page', function () {
    $this->get('/contact')->assertSuccessful();
});

it('can view a dynamic page by slug', function () {
    $this->get('/ai')->assertSuccessful();
});

it('returns 404 for nonexistent page slug', function () {
    $this->get('/nonexistent')->assertNotFound();
});

it('can view the blog index', function () {
    $this->get('/blog')->assertSuccessful();
});

it('can view a blog post', function () {
    $this->get('/blog/test-post')->assertSuccessful();
});

it('returns 404 for nonexistent blog post', function () {
    $this->get('/blog/nonexistent')->assertNotFound();
});

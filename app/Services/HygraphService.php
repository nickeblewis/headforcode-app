<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HygraphService
{
    private string $authToken;

    public function __construct(private string $url = '')
    {
        $this->url = config('services.hygraph.url');
        $this->authToken = config('services.hygraph.auth_token') ?? '';
    }

    /**
     * @return array<string, mixed>
     */
    public function query(string $query, array $variables = []): array
    {
        $callback = function () use ($query, $variables) {
            $response = Http::post($this->url, [
                'query' => $query,
                'variables' => (object) $variables,
            ]);

            return $response->json('data') ?? [];
        };

        if (app()->environment('local')) {
            return $callback();
        }

        $cacheKey = 'hygraph_'.md5($query.json_encode($variables));

        return Cache::remember($cacheKey, 3600, $callback);
    }

    /**
     * @return array<string, mixed>
     */
    public function mutate(string $query, array $variables = []): array
    {
        Log::debug('Hygraph mutation request', [
            'url' => $this->url,
            'has_token' => $this->authToken !== '',
            'query' => $query,
            'variables' => $variables,
        ]);

        $response = Http::withToken($this->authToken)
            ->post($this->url, [
                'query' => $query,
                'variables' => (object) $variables,
            ]);

        if ($response->failed()) {
            Log::error('Hygraph mutation HTTP error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        }

        $json = $response->json();

        if (! empty($json['errors'])) {
            Log::error('Hygraph mutation GraphQL errors', [
                'errors' => $json['errors'],
            ]);
        }

        Log::debug('Hygraph mutation response', [
            'status' => $response->status(),
            'data' => $json['data'] ?? null,
        ]);

        return $json['data'] ?? [];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function updatePageContent(string $slug, array $content): ?array
    {
        $data = $this->mutate('
            mutation UpdatePage($slug: String!, $content: RichTextAST!) {
                updatePage(where: { slug: $slug }, data: { content: $content }) {
                    id
                    slug
                }
            }
        ', ['slug' => $slug, 'content' => $content]);

        return $data['updatePage'] ?? null;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function publishPage(string $slug): ?array
    {
        $data = $this->mutate('
            mutation PublishPage($slug: String!) {
                publishPage(where: { slug: $slug }) {
                    id
                    slug
                }
            }
        ', ['slug' => $slug]);

        return $data['publishPage'] ?? null;
    }

    /**
     * @return array<int, array{id: string, label: string, subtitle: string|null, url: string, image: string|null}>
     */
    public function getNavigation(): array
    {
        $data = $this->query('
            {
                pages {
                    id
                    title
                    subtitle
                    slug
                    image {
                        url
                    }
                }
            }
        ');

        return array_map(fn (array $page): array => [
            'id' => $page['id'],
            'label' => $page['title'],
            'subtitle' => $page['subtitle'] ?? null,
            'url' => '/'.$page['slug'],
            'image' => $page['image']['url'] ?? null,
        ], $data['pages'] ?? []);
    }

    /**
     * @return array{title: string, slug: string, content: array{html: string}}|null
     */
    public function getPage(string $slug): ?array
    {
        $data = $this->query('
            query GetPage($slug: String!) {
                page(where: { slug: $slug }) {
                    title
                    slug
                    content {
                        html
                    }
                }
            }
        ', ['slug' => $slug]);

        return $data['page'] ?? null;
    }

    /**
     * @return array<int, array{title: string, slug: string, excerpt: string, createdAt: string, author: array{name: string, picture: array{url: string}|null}|null}>
     */
    public function getPosts(): array
    {
        $data = $this->query('
            {
                posts(orderBy: createdAt_DESC) {
                    title
                    slug
                    excerpt
                    createdAt
                    author {
                        name
                        picture {
                            url
                        }
                    }
                }
            }
        ');

        return $data['posts'] ?? [];
    }

    /**
     * @return array{title: string, slug: string, content: array{html: string}, createdAt: string, author: array{name: string, picture: array{url: string}|null}|null}|null
     */
    public function getPost(string $slug): ?array
    {
        $data = $this->query('
            query GetPost($slug: String!) {
                post(where: { slug: $slug }) {
                    title
                    slug
                    content {
                        html
                    }
                    createdAt
                    author {
                        name
                        picture {
                            url
                        }
                    }
                }
            }
        ', ['slug' => $slug]);

        return $data['post'] ?? null;
    }
}

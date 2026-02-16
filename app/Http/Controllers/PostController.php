<?php

namespace App\Http\Controllers;

use App\Services\HygraphService;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(private HygraphService $hygraph) {}

    public function index(): Response
    {
        return Inertia::render('Blog/Index', [
            'posts' => $this->hygraph->getPosts(),
        ]);
    }

    public function show(string $slug): Response
    {
        $post = $this->hygraph->getPost($slug);

        abort_unless($post, 404);

        return Inertia::render('Blog/Show', [
            'post' => $post,
        ]);
    }
}

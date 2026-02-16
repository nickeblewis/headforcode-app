<?php

namespace App\Http\Controllers;

use App\Services\HygraphService;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function __construct(private HygraphService $hygraph) {}

    public function home(): Response
    {
        return Inertia::render('Home', [
            'page' => $this->hygraph->getPage('home'),
        ]);
    }

    public function contact(): Response
    {
        return Inertia::render('Contact', [
            'page' => $this->hygraph->getPage('contact'),
        ]);
    }

    public function show(string $slug): Response
    {
        $page = $this->hygraph->getPage($slug);

        abort_unless($page, 404);

        return Inertia::render('Page', [
            'page' => $page,
        ]);
    }
}

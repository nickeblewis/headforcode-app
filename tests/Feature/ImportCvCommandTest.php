<?php

use App\Services\HygraphService;
use Smalot\PdfParser\Document;
use Smalot\PdfParser\Parser;

it('imports a cv pdf and publishes the page', function () {
    $pdfPath = tempnam(sys_get_temp_dir(), 'cv_').'.pdf';
    file_put_contents($pdfPath, 'fake-pdf');

    $document = Mockery::mock(Document::class);
    $document->shouldReceive('getText')->andReturn("EXPERIENCE\n- Built things\n- Fixed things");

    $parser = Mockery::mock(Parser::class);
    $parser->shouldReceive('parseFile')->with($pdfPath)->andReturn($document);
    $this->app->instance(Parser::class, $parser);

    $this->mock(HygraphService::class, function ($mock) {
        $mock->shouldReceive('updatePageContent')
            ->with('cv', Mockery::type('array'))
            ->andReturn(['id' => '123', 'slug' => 'cv']);
        $mock->shouldReceive('publishPage')
            ->with('cv')
            ->once()
            ->andReturn(['id' => '123', 'slug' => 'cv']);
    });

    $this->artisan('hygraph:import-cv', ['path' => $pdfPath])
        ->assertSuccessful();

    unlink($pdfPath);
});

it('fails when file does not exist', function () {
    $this->artisan('hygraph:import-cv', ['path' => '/nonexistent/file.pdf'])
        ->assertFailed()
        ->expectsOutput('File not found: /nonexistent/file.pdf');
});

it('fails when pdf contains no text', function () {
    $pdfPath = tempnam(sys_get_temp_dir(), 'cv_').'.pdf';
    file_put_contents($pdfPath, 'fake-pdf');

    $document = Mockery::mock(Document::class);
    $document->shouldReceive('getText')->andReturn('   ');

    $parser = Mockery::mock(Parser::class);
    $parser->shouldReceive('parseFile')->with($pdfPath)->andReturn($document);
    $this->app->instance(Parser::class, $parser);

    $this->artisan('hygraph:import-cv', ['path' => $pdfPath])
        ->assertFailed()
        ->expectsOutput('PDF contains no extractable text.');

    unlink($pdfPath);
});

it('fails when hygraph mutation returns null', function () {
    $pdfPath = tempnam(sys_get_temp_dir(), 'cv_').'.pdf';
    file_put_contents($pdfPath, 'fake-pdf');

    $document = Mockery::mock(Document::class);
    $document->shouldReceive('getText')->andReturn('Some CV text');

    $parser = Mockery::mock(Parser::class);
    $parser->shouldReceive('parseFile')->with($pdfPath)->andReturn($document);
    $this->app->instance(Parser::class, $parser);

    $this->mock(HygraphService::class, function ($mock) {
        $mock->shouldReceive('updatePageContent')->andReturnNull();
    });

    $this->artisan('hygraph:import-cv', ['path' => $pdfPath])
        ->assertFailed()
        ->expectsOutput('Failed to update page content in Hygraph.');

    unlink($pdfPath);
});

it('skips publishing when no-publish flag is set', function () {
    $pdfPath = tempnam(sys_get_temp_dir(), 'cv_').'.pdf';
    file_put_contents($pdfPath, 'fake-pdf');

    $document = Mockery::mock(Document::class);
    $document->shouldReceive('getText')->andReturn("EXPERIENCE\n- Built things");

    $parser = Mockery::mock(Parser::class);
    $parser->shouldReceive('parseFile')->with($pdfPath)->andReturn($document);
    $this->app->instance(Parser::class, $parser);

    $this->mock(HygraphService::class, function ($mock) {
        $mock->shouldReceive('updatePageContent')
            ->andReturn(['id' => '123', 'slug' => 'cv']);
        $mock->shouldNotReceive('publishPage');
    });

    $this->artisan('hygraph:import-cv', ['path' => $pdfPath, '--no-publish' => true])
        ->assertSuccessful();

    unlink($pdfPath);
});

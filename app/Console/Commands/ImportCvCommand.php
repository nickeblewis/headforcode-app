<?php

namespace App\Console\Commands;

use App\Services\CvTextToAstConverter;
use App\Services\HygraphService;
use Illuminate\Console\Command;
use Smalot\PdfParser\Parser;

class ImportCvCommand extends Command
{
    protected $signature = 'hygraph:import-cv {path} {--slug=cv} {--no-publish}';

    protected $description = 'Parse a CV PDF and push its content to the Hygraph CV page';

    public function handle(Parser $parser, CvTextToAstConverter $converter, HygraphService $hygraph): int
    {
        $path = $this->argument('path');
        $slug = $this->option('slug');

        if (! file_exists($path)) {
            $this->error("File not found: {$path}");

            return self::FAILURE;
        }

        $this->info('Parsing PDF...');
        $text = $parser->parseFile($path)->getText();

        if (trim($text) === '') {
            $this->error('PDF contains no extractable text.');

            return self::FAILURE;
        }

        $ast = $converter->convert($text);

        $this->info("Updating page '{$slug}' in Hygraph...");
        $result = $hygraph->updatePageContent($slug, $ast);

        if ($result === null) {
            $this->error('Failed to update page content in Hygraph.');

            return self::FAILURE;
        }

        $this->info('Page content updated successfully.');

        if (! $this->option('no-publish')) {
            $this->info('Publishing page...');
            $hygraph->publishPage($slug);
            $this->info('Page published.');
        }

        return self::SUCCESS;
    }
}

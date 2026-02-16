<?php

use App\Services\CvTextToAstConverter;

beforeEach(function () {
    $this->converter = new CvTextToAstConverter;
});

it('converts all-caps lines to heading-two nodes', function () {
    $result = $this->converter->convert('EXPERIENCE');

    expect($result['children'])->toHaveCount(1)
        ->and($result['children'][0]['type'])->toBe('heading-two')
        ->and($result['children'][0]['children'][0]['text'])->toBe('EXPERIENCE');
});

it('converts regular lines to paragraph nodes', function () {
    $result = $this->converter->convert('Some regular text here.');

    expect($result['children'])->toHaveCount(1)
        ->and($result['children'][0]['type'])->toBe('paragraph');
});

it('converts bullet lines to bulleted-list nodes', function (string $bullet) {
    $result = $this->converter->convert("{$bullet} First item\n{$bullet} Second item");

    expect($result['children'])->toHaveCount(1)
        ->and($result['children'][0]['type'])->toBe('bulleted-list')
        ->and($result['children'][0]['children'])->toHaveCount(2)
        ->and($result['children'][0]['children'][0]['type'])->toBe('list-item');
})->with(['-', '*', "\u{2022}", "\u{00B7}"]);

it('skips empty lines', function () {
    $result = $this->converter->convert("Hello\n\n\nWorld");

    expect($result['children'])->toHaveCount(2)
        ->and($result['children'][0]['type'])->toBe('paragraph')
        ->and($result['children'][1]['type'])->toBe('paragraph');
});

it('does not treat short all-caps as headings', function () {
    $result = $this->converter->convert('CV');

    expect($result['children'][0]['type'])->toBe('paragraph');
});

it('does not treat all-caps lines ending with period as headings', function () {
    $result = $this->converter->convert('THIS IS A SENTENCE.');

    expect($result['children'][0]['type'])->toBe('paragraph');
});

it('handles mixed content correctly', function () {
    $text = "SKILLS\n- PHP\n- JavaScript\n\nSome description text";
    $result = $this->converter->convert($text);

    expect($result['children'])->toHaveCount(3)
        ->and($result['children'][0]['type'])->toBe('heading-two')
        ->and($result['children'][1]['type'])->toBe('bulleted-list')
        ->and($result['children'][2]['type'])->toBe('paragraph');
});

it('returns empty children for empty input', function () {
    $result = $this->converter->convert('');

    expect($result['children'])->toBeEmpty();
});

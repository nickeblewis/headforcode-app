<?php

namespace App\Services;

class CvTextToAstConverter
{
    /**
     * @return array{children: array<int, array<string, mixed>>}
     */
    public function convert(string $text): array
    {
        $lines = explode("\n", $text);
        $children = [];
        $currentListItems = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '') {
                $this->flushList($children, $currentListItems);

                continue;
            }

            if ($this->isBullet($trimmed)) {
                $bulletText = $this->stripBullet($trimmed);
                $currentListItems[] = $this->listItem($bulletText);

                continue;
            }

            $this->flushList($children, $currentListItems);

            if ($this->isHeading($trimmed)) {
                $children[] = $this->heading($trimmed);
            } else {
                $children[] = $this->paragraph($trimmed);
            }
        }

        $this->flushList($children, $currentListItems);

        return ['children' => $children];
    }

    private function isHeading(string $line): bool
    {
        return mb_strlen($line) >= 3
            && $line === mb_strtoupper($line)
            && ! str_ends_with($line, '.');
    }

    private function isBullet(string $line): bool
    {
        return (bool) preg_match('/^[\x{2022}\x{00B7}\-\*]\s/u', $line);
    }

    private function stripBullet(string $line): string
    {
        return trim(preg_match('/^[\x{2022}\x{00B7}\-\*]\s*(.*)/u', $line, $matches) ? $matches[1] : $line);
    }

    /**
     * @param  array<int, array<string, mixed>>  &$children
     * @param  array<int, array<string, mixed>>  &$items
     */
    private function flushList(array &$children, array &$items): void
    {
        if ($items !== []) {
            $children[] = [
                'type' => 'bulleted-list',
                'children' => $items,
            ];
            $items = [];
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function heading(string $text): array
    {
        return [
            'type' => 'heading-two',
            'children' => [['text' => $text]],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function paragraph(string $text): array
    {
        return [
            'type' => 'paragraph',
            'children' => [['text' => $text]],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function listItem(string $text): array
    {
        return [
            'type' => 'list-item',
            'children' => [
                [
                    'type' => 'list-item-child',
                    'children' => [['text' => $text]],
                ],
            ],
        ];
    }
}

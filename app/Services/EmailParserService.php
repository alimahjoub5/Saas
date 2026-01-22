<?php

namespace App\Services;

class EmailParserService
{
    public function parse(string $rawEmail): array
    {
        return [
            'title' => $this->extractBetween($rawEmail, 'Title:', "\n"),
            'description' => $this->extractBetween($rawEmail, 'Description:', "\n---"),
            'budget' => $this->extractBudget($rawEmail),
            'skills' => $this->extractList($rawEmail, 'Skills:'),
            'platform' => $this->extractBetween($rawEmail, 'Platform:', "\n"),
            'url' => $this->extractUrl($rawEmail),
            'posted_at' => null,
            'client_country' => $this->extractBetween($rawEmail, 'Country:', "\n"),
            'language' => $this->extractBetween($rawEmail, 'Language:', "\n"),
            'tags' => [],
            'raw_text' => $rawEmail,
        ];
    }

    protected function extractBetween(string $text, string $start, string $end): ?string
    {
        $pattern = '/' . preg_quote($start, '/') . '\s*(.*?)' . preg_quote($end, '/') . '/s';

        if (preg_match($pattern, $text, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    protected function extractBudget(string $text): ?float
    {
        if (preg_match('/\b(\d+[\.,]?\d*)\s*(EUR|USD|€|\$)?/i', $text, $matches)) {
            return (float) str_replace(',', '.', $matches[1]);
        }

        return null;
    }

    protected function extractList(string $text, string $label): array
    {
        $value = $this->extractBetween($text, $label, "\n");

        if (! $value) {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $value)));
    }

    protected function extractUrl(string $text): ?string
    {
        if (preg_match('/https?:\/\/\S+/i', $text, $matches)) {
            return rtrim($matches[0], ".,)");
        }

        return null;
    }
}

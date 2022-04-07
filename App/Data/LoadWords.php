<?php
declare(strict_types=1);
namespace App\Data;

class LoadWords
{
    private string $words;
    private const FILE_PATH = __DIR__ . '/words.json';

    public function __construct()
    {
        $this->words = file_get_contents(self::FILE_PATH, true);
    }

    public function getWords(): string
    {
        return $this->words;
    }
}
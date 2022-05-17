<?php

declare(strict_types=1);

namespace App\Data;

class SelectWords
{
    public function getRandomWord(array $words)
    {
        $randomIndex = random_int(0, \count($words) - 1);

        return $words[$randomIndex];
    }
}

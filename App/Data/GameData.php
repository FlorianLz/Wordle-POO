<?php

declare(strict_types=1);

namespace App\Data;

class GameData implements GameInterface
{
    public function isGameStarted(): bool
    {
        return isset($_COOKIE['gameData']) && 'PLAYING' === json_decode($_COOKIE['gameData'])->status;
    }

    public function getGameData(): string
    {
        return $_COOKIE['gameData'];
    }

    public function setGameData(string $gameData): void
    {
        setcookie('gameData', $gameData, time() + 3600, '/');
    }

    public function deleteGameData(): void
    {
        setcookie('gameData', '', time() - 3600, '/');
    }
}

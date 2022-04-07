<?php

namespace App\Data;

interface GameInterface
{
    public function isGameStarted(): bool;
    public function getGameData(): string;
    public function setGameData(string $gameData): void;
    public function deleteGameData(): void;
}
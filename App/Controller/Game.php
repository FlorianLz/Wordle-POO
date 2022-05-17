<?php

declare(strict_types=1);

namespace App\Controller;

class Game implements Controller
{
    public function render(): void
    {
        $game = new \App\Game\Game();
        $game->initGame();
        $wordle = json_decode(json_encode($game->startGame()), false);
        require __DIR__.'../../views/template.php';
    }
}

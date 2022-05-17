<?php

declare(strict_types=1);

namespace App\Game;

use App\Data\GameData;
use App\Data\LoadWords;
use App\Data\SelectWords;

class Game
{
    private Word $word;
    public int $essais_restants;
    public bool $alreadyStarted = false;
    public array $tentatives = [];
    private string $status;
    private GameData $gameData;
    private string $motPropose = '';

    public function __construct()
    {
        $this->gameData = new GameData();
    }

    public function initGame(): void
    {
        $gameStarted = $this->gameData->isGameStarted();

        if ($gameStarted) {
            $this->setPlayingGame();

            return;
        }
        $this->setNewGame();
    }

    public function startGame(): array
    {
        $object = [
            'word' => $this->word->getWord(),
            'word_count' => $this->word->getLength(),
            'essais_restants' => $this->essais_restants,
            'tentatives' => $this->tentatives,
            'tabLettres' => $this->word->getTabOfLetters(),
            'status' => $this->status,
        ];
        $this->gameData->setGameData(json_encode($object));

        return $object;
    }

    private function setNewGame(): void
    {
        $loadWords = new LoadWords();
        $selectWords = new SelectWords();
        $words = json_decode($loadWords->getWords(), true, 512, JSON_THROW_ON_ERROR);
        $randomWord = $selectWords->getRandomWord($words);
        $this->word = new Word($randomWord);
        $this->essais_restants = 6;
        $this->status = 'PLAYING'; // en php 8.1 tu vas pouvoir utiliser les enums https://www.php.net/manual/fr/language.enumerations.overview.php
    }

    private function setPlayingGame(): void
    {
        $game = $this->gameData->getGameData();
        // attention, au moindre souci de format de game, ça plante.
        // faudrait utiliser une option JSON_THROW_ON_ERROR et attrapper l'exception
        // dommage que tu décode 4x au lieu de stocker le résultat
        $game = json_decode($game, false, 512, JSON_THROW_ON_ERROR);

        $this->word = new Word($game->word);
        $this->alreadyStarted = true;
        $this->essais_restants = $game->essais_restants;
        $this->tabLettres = $game->tabLettres;
        $this->tentatives = $game->tentatives;

        if ($this->essais_restants <= 0) {
            return;
        }

        $this->setProposition();

        if ($this->motPropose === $this->word->getWord()) {
            $this->status = 'WIN';
            $this->essais_restants = 0;
            $this->gameData->deleteGameData();

            return;
        }

        $this->status = 'PLAYING';
        if (0 === $this->essais_restants) {
            $this->status = 'LOSE';
        }
    }

    private function setProposition(): void
    {
        // 4 sous-niveaux beurk...
        if (!isset($_GET['letter0'])) {
            return;
        }

        $tabTentative = [];
        --$this->essais_restants;

        // Vérifier si les lettres proposées sont dans le mot
        for ($i = 0; $i < $this->word->getLength(); ++$i) {
            $letter = new Letter($_GET["letter$i"], $i);
            $this->motPropose .= $letter->getLetter();

            if ($letter->isInWord($this->word) && $letter->isInGoodPosition($this->word)) {
                // Lettre dans le mot
                // Lettre à la bonne position
                $tabTentative[$i] = ['letter' => $letter->getLetter(), 'status' => 'OK'];
                continue;
            }

            if ($letter->isInWord($this->word) && !$letter->isInGoodPosition($this->word)) {
                // Lettre dans le mot
                // Lettre dans la mauvaise position
                $tabTentative[$i] = ['letter' => $letter->getLetter(), 'status' => 'BP'];
                continue;
            }

            // Lettre pas dans le mot
            $tabTentative[$i] = ['letter' => $letter->getLetter(), 'status' => 'KO'];
        }

        $this->tentatives[] = $tabTentative;
    }
}

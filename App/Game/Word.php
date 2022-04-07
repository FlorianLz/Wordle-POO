<?php

namespace App\Game;

class Word
{
    public string $word;

    public function __construct($mot)
    {
        $this->word = $mot;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function getLength()
    {
        return strlen($this->word);
    }

    public function getTabOfLetters()
    {
        $letters = [];
        foreach (str_split($this->word) as $key=>$letter) {
            $letters[] = new Letter($letter,$key);
        }
        return $letters;
    }

}
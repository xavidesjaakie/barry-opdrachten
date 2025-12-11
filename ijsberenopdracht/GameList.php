<?php

class GameList
{
    /** @var Game[] */
    private array $games = [];

    public function addGame(Game $game): void
    {
        $this->games[] = $game;
    }

    public function getCurrentGame(): ?Game
    {
        if (empty($this->games)) {
            return null;
        }
        return $this->games[array_key_last($this->games)];
    }

    public function getGames(): array
    {
        return $this->games;
    }
}

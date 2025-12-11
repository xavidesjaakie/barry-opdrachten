<?php

class TurnList
{
    /** @var Turn[] */
    private array $turns = [];

    public function addTurn(Turn $turn): void
    {
        $this->turns[] = $turn;
    }

    public function getCurrentTurn(): ?Turn
    {
        if (empty($this->turns)) {
            return null;
        }
        return $this->turns[array_key_last($this->turns)];
    }

    public function getAmountTurns(): int
    {
        return count($this->turns);
    }

    public function getTurns(): array
    {
        return $this->turns;
    }
}

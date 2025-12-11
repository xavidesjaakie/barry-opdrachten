<?php

abstract class AbstractDie
{
    protected int $value = 0;
    protected int $iceHoles = 0;
    protected int $polarBears = 0;
    protected int $penguins = 0;

    public function roll(): void
    {
        $this->value = rand(1, $this->getMaxValue());
        $this->calculateAnimals();
    }

    abstract protected function getMaxValue(): int;

    // Som van boven + onderkant
    abstract protected function getTopBottomSum(): int;

    protected function calculateAnimals(): void
    {
        // Zelfde regel voor beide soorten dobbelstenen:
        // bij 1, 3, 5 is er een wak in het midden
        if (in_array($this->value, [1, 3, 5], true)) {
            $this->iceHoles = 1;
            // IJsberen = dobbelwaarde - 1 (0,2,4)
            $this->polarBears = $this->value - 1;
            // Pinguïns = onderkant (7 bij kubus, 13 bij pentagon) - bovenkant
            $this->penguins = $this->getTopBottomSum() - $this->value;
        } else {
            $this->iceHoles = 0;
            $this->polarBears = 0;
            $this->penguins = 0;
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getIceHoles(): int
    {
        return $this->iceHoles;
    }

    public function getPolarBears(): int
    {
        return $this->polarBears;
    }

    public function getPenguins(): int
    {
        return $this->penguins;
    }

    abstract public function draw(): string;
}

<?php
require_once __DIR__ . '/Hint.php';

class HintList
{
    /** @var Hint[] */
    private array $hints = [];

    public function addHint(Hint $hint): void
    {
        $this->hints[] = $hint;
    }

    public function getRandomHint(): ?Hint
    {
        if (empty($this->hints)) {
            return null;
        }
        $index = array_rand($this->hints);
        return $this->hints[$index];
    }
}

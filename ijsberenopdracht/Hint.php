<?php

class Hint
{
    private string $hint;

    public function __construct(string $hint)
    {
        $this->hint = $hint;
    }

    public function getHintString(): string
    {
        return $this->hint;
    }
}

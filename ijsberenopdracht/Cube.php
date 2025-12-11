<?php
require_once __DIR__ . '/AbstractDie.php';

class Cube extends AbstractDie
{
    protected function getMaxValue(): int
    {
        return 6;
    }

    protected function getTopBottomSum(): int
    {
        return 7; // standaard dobbelsteen
    }

    public function draw(): string
    {
        $svg = "<svg width='120' height='120'>
            <rect x='10' y='10' rx='15' ry='15' width='100' height='100'
                  style='fill:lightblue;stroke:black;stroke-width:3;' />";

        // wak (midden, blauw)
        if (in_array($this->value, [1, 3, 5], true)) {
            $svg .= "<circle cx='60' cy='60' r='7' fill='blue' />";
        }

        // witte stippen (ijsberen-plekjes)
        // linksboven, rechtsboven, linksonder, rechtsonder, links-midden, rechts-midden
        $dots = [];

        if (in_array($this->value, [2, 3, 4, 5, 6], true)) {
            // diagonaal: links-onder + rechts-boven
            $dots[] = [30, 90];
            $dots[] = [90, 30];
        }

        if (in_array($this->value, [4, 5, 6], true)) {
            // linksboven + rechtsonder
            $dots[] = [30, 30];
            $dots[] = [90, 90];
        }

        if ($this->value === 6) {
            // midden links + midden rechts
            $dots[] = [30, 60];
            $dots[] = [90, 60];
        }

        foreach ($dots as [$cx, $cy]) {
            $svg .= "<circle cx='{$cx}' cy='{$cy}' r='6' fill='white' />";
        }

        $svg .= "</svg>";
        return $svg;
    }
}

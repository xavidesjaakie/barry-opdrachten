<?php
require_once __DIR__ . '/AbstractDie.php';

class PentagonDie extends AbstractDie
{
    protected function getMaxValue(): int
    {
        return 12;
    }

    protected function getTopBottomSum(): int
    {
        return 13; // volgens opdracht: top + bottom = 13
    }

    public function draw(): string
    {
        // simpele pentagon in SVG
        $points = "60,10 100,40 85,95 35,95 20,40";

        $svg = "<svg width='120' height='120'>
            <polygon points='{$points}' style='fill:lightblue;stroke:black;stroke-width:3;' />";

        // wak in het midden
        if (in_array($this->value, [1, 3, 5], true)) {
            $svg .= "<circle cx='60' cy='55' r='7' fill='blue' />";
        }

        // ijsberen rond het wak (2 of 4 witte stippen)
        $bearDots = [];

        if (in_array($this->value, [3, 5], true)) {
            // 2 ijsberen
            $bearDots[] = [40, 75];
            $bearDots[] = [80, 75];
        }

        if ($this->value === 5) {
            // nog 2 extra ijsberen
            $bearDots[] = [45, 35];
            $bearDots[] = [75, 35];
        }

        foreach ($bearDots as [$cx, $cy]) {
            $svg .= "<circle cx='{$cx}' cy='{$cy}' r='6' fill='white' />";
        }

        // toon ook het getal in het midden boven
        $svg .= "<text x='60' y='18' text-anchor='middle' font-size='12' fill='black'>{$this->value}</text>";

        $svg .= "</svg>";
        return $svg;
    }
}

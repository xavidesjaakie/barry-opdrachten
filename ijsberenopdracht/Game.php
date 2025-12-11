<?php
require_once __DIR__ . '/Cube.php';
require_once __DIR__ . '/PentagonDie.php';
require_once __DIR__ . '/TurnList.php';
require_once __DIR__ . '/Turn.php';

class Game
{
    /** @var AbstractDie[] */
    private array $dice = [];

    private TurnList $turnList;
    private int $resultIceHoles = 0;
    private int $resultPolarBears = 0;
    private int $resultPenguins = 0;

    private int $wrongGuesses = 0;
    private int $correct = 0;

    private string $diceType; // 'cube' of 'pentagon'

    public function __construct(int $amount, string $diceType)
    {
        $this->diceType = $diceType === 'pentagon' ? 'pentagon' : 'cube';
        $this->turnList = new TurnList();

        // dobbelstenen gooien
        for ($i = 0; $i < $amount; $i++) {
            if ($this->diceType === 'pentagon') {
                $die = new PentagonDie();
            } else {
                $die = new Cube();
            }
            $die->roll();
            $this->dice[] = $die;
        }

        $this->calculateResult();
    }

    private function calculateResult(): void
    {
        foreach ($this->dice as $die) {
            $this->resultIceHoles += $die->getIceHoles();
            $this->resultPolarBears += $die->getPolarBears();
            $this->resultPenguins += $die->getPenguins();
        }
    }

    public function drawDice(): void
    {
        foreach ($this->dice as $die) {
            echo "<span style='margin:10px; display:inline-block;'>" . $die->draw() . "</span>";
        }
    }

    public function addGuess(int $iceHoles, int $polarBears, int $penguins): void
    {
        $turn = new Turn($iceHoles, $polarBears, $penguins);
        $this->turnList->addTurn($turn);
    }

    public function checkGuess(): string
    {
        $turn = $this->turnList->getCurrentTurn();
        if ($turn === null) {
            return '';
        }

        if (
            $turn->getGuessIceHoles() === $this->resultIceHoles &&
            $turn->getGuessPolarBears() === $this->resultPolarBears &&
            $turn->getGuessPenguins() === $this->resultPenguins
        ) {
            $this->correct = 1;
            $_SESSION['status'] = 'correct';
            return 'Correct geraden!';
        }

        $this->wrongGuesses++;
        $_SESSION['status'] = 'wrong';
        return 'Helaas fout.';
    }

    public function getGameTurns(): int
    {
        return $this->turnList->getAmountTurns();
    }

    public function getWrongAnswers(): int
    {
        return $this->wrongGuesses;
    }

    public function getScore(): int
    {
        return $this->correct;
    }

    public function getAnswer(): array
    {
        $_SESSION['status'] = 'answer';
        return [
            $this->resultIceHoles,
            $this->resultPolarBears,
            $this->resultPenguins
        ];
    }

    public function getDiceType(): string
    {
        return $this->diceType;
    }
}

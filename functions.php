<?php

//Generates symbol objects
function newSymbol(string $name, float $multiplier, int $spinChance): object
{
    $symbol = new stdClass();
    $symbol->name = $name;
    $symbol->multiplier = $multiplier; //rewards multiplayer
    $symbol->spinChance = $spinChance; //range 1 - 100. will be multiplied with rand to determine spin value
    return $symbol;
}

// Function determines the highest random number multiplied with symbols spin chance (or power), and then returns index.
function highestSpin (array $symbols): int
{
    $arrSpin = [];
    foreach ($symbols as $symbol) {
        $spin = $symbol->spinChance * rand(1, 100);
        $arrSpin[] = $spin;
    }
    return array_search(max($arrSpin), $arrSpin);
}

//fills gameboard with highest spin symbols
function spin(array $gameBoard, array $symbols): array
{
    foreach ($gameBoard as $line) {
        for ($j = 0; $j < 5; $j++){
            $line[] = $symbols[highestSpin($symbols)]->name;
        }
        array_shift($gameBoard);
        $gameBoard[] = $line;
    }
    return $gameBoard;
}

//checks paylines, calculates payout with according symbol multipliers.
function roundResult (array $payLines, array $symbols): float
{
    $match4 = 3;
    $match5 = 10;
    $multiplier = 0;
    $result = 0;
    foreach ($payLines as $payLine) {
        $matches = 0;
        for ($i = 0; $i < count($payLine) - 1; $i++) {

            if ($payLine[$i] == $payLine[$i + 1]) {
                $matches++;
            } else break;
        }
        foreach ($symbols as $symbol) {
            if ($payLine[$i] == $symbol->name && $matches > 1) {
                $multiplier = $symbol->multiplier;
            }
        }
        if ($matches == 4) {
            $result += $matches * $multiplier * $match5;
        } else if ($matches == 3) {
            $result += $matches * $multiplier * $match4;
        } else if ($matches == 2) {
            $result += $matches * $multiplier;
        }
    }
    return $result;

}

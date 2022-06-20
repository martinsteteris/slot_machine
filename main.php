<?php

require "functions.php";

$symbols = [
//    newSymbol("0", 0.5, 70),
    newSymbol("1", 0.5, 70),
    newSymbol("2", 0.5, 70),
    newSymbol("3", 2, 60),
    newSymbol("4", 3, 50),
    newSymbol("5", 5, 40),
    newSymbol("6", 10, 30),
    newSymbol("7", 20, 20)
];

//empty gameboard
$gameBoard = [[], [], []];

$playerCredit = 20;

while ($playerCredit > 0) {
    system('clear');
    echo "Your balance is $playerCredit peso." . PHP_EOL;
    $bet = readline('Enter your bet:  ');
    echo PHP_EOL;
    if (! is_numeric($bet)) {
        echo "USE DIGITS PLS!" . PHP_EOL;
        sleep(1);
        continue;
    }
    if ($bet > $playerCredit) {
        echo "Not enough peso!" . PHP_EOL;
        sleep(1);
        continue;
    } else {
        $playerCredit -= $bet;
    }
    $newSpin = spin($gameBoard, $symbols);

//    sleep(1);
    echo "{$newSpin[0][0]} | {$newSpin[0][1]} | {$newSpin[0][2]} | {$newSpin[0][3]} | {$newSpin[0][4]}" . PHP_EOL;
    sleep(1);
    echo "{$newSpin[1][0]} | {$newSpin[1][1]} | {$newSpin[1][2]} | {$newSpin[1][3]} | {$newSpin[1][4]}" . PHP_EOL;
    sleep(1);
    echo "{$newSpin[2][0]} | {$newSpin[2][1]} | {$newSpin[2][2]} | {$newSpin[2][3]} | {$newSpin[2][4]}" . PHP_EOL;
    sleep(1);
    $payLines = [
        [$newSpin[0][0], $newSpin[0][1], $newSpin[0][2], $newSpin[0][3], $newSpin[0][4]],
        [$newSpin[1][0], $newSpin[1][1], $newSpin[1][2], $newSpin[1][3], $newSpin[1][4]],
        [$newSpin[2][0], $newSpin[2][1], $newSpin[2][2], $newSpin[2][3], $newSpin[2][4]],
        [$newSpin[0][0], $newSpin[1][1], $newSpin[2][2], $newSpin[1][3], $newSpin[0][4]],
        [$newSpin[2][0], $newSpin[1][1], $newSpin[0][2], $newSpin[1][3], $newSpin[2][4]]
    ];
    $result = $bet * roundResult($payLines, $symbols);
    echo "You won $result peso!" . PHP_EOL;
    $playerCredit += $result;
    if ($result > 0) {
        $playAgain = readline('Wanna win again? y/n: ');
    } else {
        $playAgain = readline('Wanna lose again? y/n: ');
    }
    if ($playAgain == 'y' || $playAgain == 'Y' ) {
        continue;
    } else {
        exit;
    }
}
echo PHP_EOL . "Thanks for playing!" . PHP_EOL;

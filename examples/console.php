<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

while(true)
{
    $game->getBoard()->displayWithMoves();
    $move = readline("Enter move: ");
    $game->getBoard()->moveByIndex((int) $move);
}
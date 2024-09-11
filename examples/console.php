<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

//$notationGame = "b,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,w";
//notationGame($game, $notationGame);

//setMovesGame($game);
justGame($game);

function notationGame($game, $notation)
{
    $game->getTurn()->setWhite();
    $game->getBoard()->getPositionCollection()->setNotation($notation);
    //$game->getBoard()->displayWithMoves();
}

function setMovesGame($game)
{
    $moves = [1, 6, 3, 1, 5, 6, 7, 2, 2, 1];
    foreach($moves as $move)
    {
        $game->getBoard()->moveByIndex((int) $move);
    }
}

function justGame($game)
{
    while(!$game->isOver())
    {
        $game->getBoard()->displayWithMoves();
        $move = readline("Enter move: ");
        $game->getBoard()->moveByIndex((int) $move);
    }
    $game->getBoard()->displayWithMoves();
    echo $game->getTurn()->getOppositeValue()." wins!".PHP_EOL.PHP_EOL;
}
<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

$notationGame = "e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,b,b,e,e,W,e,e,e";
notationGame($game, $notationGame);

//setMovesGame($game);
//justGame($game);

function notationGame($game, $notation)
{
    $game->getTurn()->setWhite();
    $game->getBoard()->getPositionCollection()->setNotation($notation);
    $game->getBoard()->displayWithMoves();
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
    while(true)
    {
        $game->getBoard()->displayWithMoves();
        $move = readline("Enter move: ");
        $game->getBoard()->moveByIndex((int) $move);
    }
}
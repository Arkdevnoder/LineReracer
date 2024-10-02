<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

$notation = "B,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,e,W";
notationGame($game, $notation);
justGame($game);

function notationGame($game, $notation)
{
    //$game->getTurn()->setBlack();
    $game->getBoard()->getPositionCollection()->setNotation($notation);
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
        $computer = $game->getEngine()->compute();
        $hints = $computer->getResult();
        $game->getBoard()->moveByIndex(array_search(min($hints), $hints)+1);
    }
    $game->getBoard()->displayWithMoves();
    if(!$game->isDraw())
    {
        echo $game->getTurn()->getOppositeValue()." wins!".PHP_EOL.PHP_EOL;
    } else {
        echo "Draw!".PHP_EOL.PHP_EOL;
    }
    
}
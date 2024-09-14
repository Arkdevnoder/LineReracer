<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

//$notation = "b,b,b,b,b,b,b,b,b,b,e,b,e,e,b,e,w,e,e,e,e,w,w,w,w,w,w,w,w,w,w,w";
//notationGame($game, $notation);
justGame($game);

function notationGame($game, $notation)
{
    $game->getTurn()->setBlack();
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
    $k = 0;
    while(!$game->isOver())
    {
        $computer = $game->getEngine()->compute();
        $hints = $computer->getResult();
        $game->getBoard()->displayWithMoves();
        if($k > 0)
        {
            $game->getBoard()->moveByIndex(array_search(min($hints), $hints)+1);
        }
        $game->getBoard()->displayWithMoves();
        $move = readline("Enter move: ");
        $game->getBoard()->moveByIndex((int) $move);
        $k++;
    }
    $game->getBoard()->displayWithMoves();
    echo $game->getTurn()->getOppositeValue()." wins!".PHP_EOL.PHP_EOL;
}
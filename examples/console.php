<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

$game = (new \Arknet\LineReracer\Definition\Game);

while(!$game->isOver())
{
    $game->consoleCycle();
}
$game->consoleGameOver();
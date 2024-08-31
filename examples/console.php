<?php

ini_set("display_errors", 0);

require __DIR__."/../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

var_dump($game->getBoard()->getPositionCollection()->getOccupiedIndexes());
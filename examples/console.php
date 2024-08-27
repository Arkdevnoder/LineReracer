<?php

ini_set("display_errors", 0);

require "../vendor/autoload.php";

use Arknet\LineReracer\Definition\Game;

$game = (new Game);

var_dump($game->getBoard());
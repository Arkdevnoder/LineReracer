<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Game;

trait Gameable
{
    private Game $game;

    public function setGame(Game $game): object
    {
        $this->game = $game;
        return $this;
    }

    public function getGame(): Game
    {
        return $this->game;
    }
}
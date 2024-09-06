<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Game;

trait Directionable
{
    private direction $direction;

    public function setDirection(string $direction): object
    {
        $this->direction = $direction;
        return $this;
    }

    public function getDirection(): int
    {
        return $this->direction;
    }
}
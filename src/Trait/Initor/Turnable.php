<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Turn;

trait Turnable
{
    private Turn $turn;

    public function setTurn(Turn $turn): object
    {
        $this->turn = $turn;
        return $this;
    }

    public function getTurn(): Turn
    {
        return $this->turn;
    }
}
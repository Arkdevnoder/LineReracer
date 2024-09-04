<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Game;

trait Indexable
{
    private int $index;

    public function setIndex(int $int): object
    {
        $this->index = $int;
        return $this;
    }

    public function getIndex(): int
    {
        return $this->index;
    }
}
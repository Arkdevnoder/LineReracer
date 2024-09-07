<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Game;

trait Lengthable
{
    private int $length;

    public function setLength(int $length): object
    {
        $this->length = $length;
        return $this;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
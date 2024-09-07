<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\MovementsCollection;
use Arknet\LineReracer\Trait\Brancher\MoveCalculator;

class JumpsMoveCalculator
{
    use MoveCalculator;

    public const IsRecursive = true;
    
    private function getMovements(int $index): MovementsCollection
    {
        return $this->getDiagonalCollector($index)->compute()->getJumps();
    }
}
<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\MovementsCollection;
use Arknet\LineReracer\Trait\Brancher\MoveCalculator;

class StepsMoveCalculator
{
    use MoveCalculator;

    public const IsRecursive = false;
    
    private function getMovements(int $index): MovementsCollection
    {
        $diagonalCollector = $this->getDiagonalCollector($index)->compute();
        $steps = $diagonalCollector->getSteps();
        return $steps;
    }
}
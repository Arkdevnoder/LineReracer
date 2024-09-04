<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Trait\Initor\Indexesable;
use Arknet\LineReracer\Entity\MovementsCollection;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;

class QueenMoveCalculator
{
    use Indexesable, PositionCollectionable;

    private array $result;

    public function getMovementsCollection() {
        foreach($this->indexes as $index)
        {
            $this->walk($index);
        }
    }

    public function walk(int $index): void
    {
        
    }


}
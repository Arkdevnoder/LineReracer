<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Actor\DiagonalCollector;
use Arknet\LineReracer\Trait\Initor\Indexesable;
use Arknet\LineReracer\Entity\MovementCollection;
use Arknet\LineReracer\Entity\MovementsCollection;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;

trait MoveCalculator
{
    use Indexesable, PositionCollectionable;

    private MovementsCollection $result;

    public function __construct(){
        $this->result = new MovementsCollection;
    }

    public function getResult(): MovementsCollection
    {
        return $this->result;
    }

    public function getMovementsCollection(): MovementsCollection {
        foreach($this->indexes as $index)
        {
            $this->walk([], $index);
        }
        return $this->getResult();
    }

    private function walk(array $trace, int $index): void
    {
        $movements = $this->getMovements($index);
        $this->walkFromMovements($movements, $trace);
    }

    private function walkFromMovements(MovementsCollection $movements, array $trace): void
    {
        $this->preWalking($movements, $trace);
        if(static::IsRecursive)
        {
            $this->movementsProcessing($movements, $trace);
        }
    }

    private function movementsProcessing(MovementsCollection $movements, array $trace): void
    {
        foreach($movements as $jumpMovementCollection)
        {
            $this->getPositionCollection()->move($jumpMovementCollection->getVector()[0]);
            $this->walk(array_merge($trace, [$movements]), $jumpMovementCollection->getVector()[0]->getToIndex());
        }
    }

    private function preWalking(MovementsCollection $movements, array $trace): void
    {
        $this->setResultIfNoMovements($movements, $trace);
    }

    private function setResultIfNoMovements(MovementsCollection $movements, array $trace): void
    {
        if($movements->countVector() == 0 || !static::IsRecursive)
        {
            $trace = $this->getTrace($movements, $trace);
            $this->updateResult($trace);
        }
    }

    private function getTrace(MovementsCollection $movements, array $trace): array
    {
        return array_merge($trace, [$movements]);
    }

    private function updateResult(array $trace): void
    {
        foreach($trace as $movementsCollection)
        {
            $this->updateResultWithMovementsCollection($movementsCollection);
        }
    }

    private function updateResultWithMovementsCollection(MovementsCollection $movementsCollection): void
    {
        foreach($movementsCollection as $movementCollection)
        {
            $this->getResult()->add($movementCollection);
        }
    }

    private function getDiagonalCollector(int $index): DiagonalCollector
    {
        return (new DiagonalCollector())->setLength($this->getLengthBasedOnIndex($index))
        ->setIndex($index)->setPositionCollection($this->getPositionCollection());
    }

    private function getLengthBasedOnIndex(int $index): int
    {
        if($this->getPositionCollection()->get($index)->isQueen())
        {
            return $this->getPositionCollection()->getMaxDiagonalDimension();
        }
        return 2;
    }
}
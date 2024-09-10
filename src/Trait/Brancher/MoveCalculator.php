<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Definition\Displayer;
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
        $this->setBasePositionAndWalk();
        return $this->getResult();
    }

    private function setBasePositionAndWalk(): void
    {
        $this->rangeIndexes();
    }

    private function rangeIndexes(): void
    {
        foreach($this->indexes as $index)
        {
            $this->walk([], $index);
        }
    }

    private function walk(array $trace, int $index): void
    {
        $movements = $this->getMovements($index);
        $this->walkFromMovements($movements, $trace);
    }

    private function walkFromMovements(MovementsCollection $movements, array $trace): void
    {
        static::IsRecursive && !($movements->isEmpty())
        ? $this->movementsProcessing($movements, $trace)
        : $this->setResultIfNoMovements($movements, $trace);
    }

    private function movementsProcessing(MovementsCollection $movements, array $trace): void
    {
        foreach($movements->getVector() as $movementCollection)
        {
            $this->movementCore($movementCollection, array_merge($trace, [$movementCollection]));
        }
    }

    private function movementCore(MovementCollection $movementCollection, array $trace): void
    {
        $initialVector = $this->getPositionCollection()->getVector();
        $movement = $movementCollection->getVector()[0];
        $this->getPositionCollection()->move($movement);
        $this->walk($trace, $movementCollection->getVector()[0]->getToIndex());
        $this->getPositionCollection()->setVector($initialVector);
    }

    private function setResultIfNoMovements(MovementsCollection $movements, array $trace): void
    {
        if($movements->countVector() == 0 || !static::IsRecursive)
        {
            !static::IsRecursive ? $this->updateResult($this->getTrace($movements, $trace)) : $this->addResult($trace);
        }
    }

    private function addResult(array $trace): void
    {
        $newMovementCollection = new MovementCollection;
        count($trace) == 0 ?: $this->traverseTrace($newMovementCollection, $trace);
    }

    private function traverseTrace(MovementCollection $newMovementCollection, array $trace): void
    {
        foreach($trace as $key => $movementCollection)
        {
            $newMovementCollection->add($movementCollection->getVector()[0]);
        }
        $this->getResult()->add($newMovementCollection);
    }

    private function getTrace(MovementsCollection $movements, array $trace): array
    {
        if(!$movements->isEmpty())
        {
            return array_merge($trace, [$movements]);
        }
        return $trace;
    }

    private function updateResult(array $trace): void
    {
        foreach($trace as $key => $movementsCollection)
        {
            !isset($trace[$key-1]) ?: $trace[$key]->merge($trace[$key - 1]);
        }
        !isset($key) ?: $this->getResult()->merge($trace[$key]);
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
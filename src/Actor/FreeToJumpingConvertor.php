<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Trait\Initor\Gameable;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;

class FreeToJumpingConvertor
{
    use Gameable, PositionCollectionable;

    private array $resultIndexes;

    private array $freeIndexes;

    private DiagonalCollector $diagonalCollector;

    public function __construct()
    {
        $this->resultIndexes = (array) null;
    }

    public function setFreeIndexes(array $freeIndexes): FreeToJumpingConvertor
    {
        $this->freeIndexes = $freeIndexes;
        return $this;
    }

    public function transform(): array
    {
        foreach($this->getFreeIndexes() as $index)
        {
            $this->performIndex($index);
        }
        return $this->resultIndexes;
    }

    private function getNewDiagonalCollector(): DiagonalCollector
    {
        return (new DiagonalCollector)->setPositionCollection($this->getPositionCollection());
    }

    private function performIndex(int $index): void
    {
        $this->getPositionCollection()->get($index)->isQueen()
        ? $this->performQueenIndex($index)
        :  $this->performPieceIndex($index);
    }

    private function performQueenIndex(int $index): void
    {
        $diagonalCollector = $this->getNewQueenDiagonalCollector($index);
        if($diagonalCollector->hasJump())
        {
            $this->resultIndexes[] = $index;
        }
    }

    private function getNewQueenDiagonalCollector(int $index): DiagonalCollector
    {
        return $this->getNewDiagonalCollector()->setLength(
            $this->getPositionCollection()->getMaxDiagonalDimension()
        )->setIndex($index)->compute();
    }

    private function performPieceIndex(int $index): void
    {
        if($this->getNewPieceDiagonalCollector($index)->hasJump())
        {
            $this->resultIndexes[] = $index;
        }
    }

    private function getNewPieceDiagonalCollector(int $index): DiagonalCollector
    {
        return $this->getNewDiagonalCollector()->setLength(2)->setIndex($index)->compute();
    }

    private function getFreeIndexes(): array
    {
        return $this->freeIndexes;
    }

}
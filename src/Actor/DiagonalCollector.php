<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Trait\Initor\Gameable;
use Arknet\LineReracer\Entity\DiagonalCollection;
use Arknet\LineReracer\Trait\Brancher\DirectionMap;
use Arknet\LineReracer\Exception\IndexNotFoundException;
use Arknet\LineReracer\Exception\ParamsNotSettedException;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;

class DiagonalCollector
{
    use Gameable, PositionCollectionable;

    private int $index;

    private int $length;

    private int $x;

    private int $y;

    private DiagonalCollection $firstDiagonalCollection;
    private DiagonalCollection $secondDiagonalCollection;
    private DiagonalCollection $thirdDiagonalCollection;
    private DiagonalCollection $fourthDiagonalCollection;

    public function compute(): object
    {
        $this->checkParams();
        $this->setCoordinatesByIndex();
        $this->continueCompute();
        return $this;
    }

    public function continueCompute(): void
    {
        for($iterator = 0; $iterator < $this->length; $iterator++)
        {
            $this->addElementsToDiagonal($iterator);
        }
    }

    public function hasJump(): bool
    {
        return $this->getFirstDiagonalCollection()->hasJump() ||
        $this->getSecondDiagonalCollection()->hasJump() ||
        $this->getThirdDiagonalCollection()->hasJump() ||
        $this->getFourthDiagonalCollection()->hasJump();
    }

    public function setIndex(int $index): object
    {
        $this->index = $index;
        return $this;
    }

    public function setLength(int $length): object
    {
        $this->length = $length;
        return $this;
    }

    public function getFirstDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->firstDiagonalCollection))
        {
            $this->firstDiagonalCollection = $this->getNewDiagonalCollection(DirectionMap::DirectionNE);
        }
        return $this->firstDiagonalCollection;
    }

    public function getSecondDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->secondDiagonalCollection))
        {
            $this->secondDiagonalCollection = $this->getNewDiagonalCollection(DirectionMap::DirectionSE);
        }
        return $this->secondDiagonalCollection;
    }

    public function getThirdDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->thirdDiagonalCollection))
        {
            $this->thirdDiagonalCollection = $this->getNewDiagonalCollection(DirectionMap::DirectionSW);
        }
        return $this->thirdDiagonalCollection;
    }

    public function getFourthDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->fourthDiagonalCollection))
        {
            $this->fourthDiagonalCollection = $this->getNewDiagonalCollection(DirectionMap::DirectionNW);
        }
        return $this->fourthDiagonalCollection;
    }

    private function getNewDiagonalCollection(string $direction): DiagonalCollection
    {
        return (new DiagonalCollection)->setPositionCollection($this->getPositionCollection())
               ->setIndex($this->index)->setDirection($direction);
    }

    private function setCoordinatesByIndex(): void
    {
        $coordinates = $this->getPositionCollection()->getCoordinatesByIndex($this->index);
        $this->x = $coordinates[0];
        $this->y = $coordinates[1];
    }

    private function addElementsToDiagonal(int $iterator): void
    {
        $this->addToFirstDiagonal($iterator);
        $this->addToSecondDiagonal($iterator);
        $this->addToThirdDiagonal($iterator);
        $this->addToFourthDiagonal($iterator);
    }

    private function addToFirstDiagonal(int $iterator): void
    {
        $this->addFirstElementByCoordinates($this->x+$iterator, $this->y+$iterator);
    }
    
    private function addToSecondDiagonal(int $iterator): void
    {
        $this->addSecondElementByCoordinates($this->x+$iterator, $this->y-$iterator);
    }

    private function addToThirdDiagonal(int $iterator): void
    {
        $this->addThirdElementByCoordinates($this->x-$iterator, $this->y-$iterator);
    }

    private function addToFourthDiagonal(int $iterator): void
    {
        $this->addFourthElementByCoordinates($this->x+$iterator, $this->y+$iterator);
    }

    private function addFirstElementByCoordinates(int $x, int $y): void
    {
        try {
            $this->getFirstDiagonalCollection()->add($this->getPositionCollection()->getElementByCoordinates($x, $y));
        } catch(IndexNotFoundException) {
            //
        }
    }

    private function addSecondElementByCoordinates(int $x, int $y): void
    {
        try {
            $this->getSecondDiagonalCollection()->add($this->getPositionCollection()->getElementByCoordinates($x, $y));
        } catch(IndexNotFoundException) {
            //
        }
    }

    private function addThirdElementByCoordinates(int $x, int $y): void
    {
        try {
            $this->getThirdDiagonalCollection()->add($this->getPositionCollection()->getElementByCoordinates($x, $y));
        } catch(IndexNotFoundException) {
            //
        }
    }

    private function addFourthElementByCoordinates(int $x, int $y): void
    {
        try {
            $this->getFourthDiagonalCollection()->add($this->getPositionCollection()->getElementByCoordinates($x, $y));
        } catch(IndexNotFoundException) {
            //
        }
    }

    private function checkParams(): void
    {
        if(!isset($this->length) || !isset($this->index) || !isset($this->positionCollection))
        {
            throw new ParamsNotSettedException;
        }
    }
}
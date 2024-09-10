<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Trait\Initor\Indexable;
use Arknet\LineReracer\Trait\Initor\Lengthable;
use Arknet\LineReracer\Entity\DiagonalCollection;
use Arknet\LineReracer\Entity\MovementsCollection;
use Arknet\LineReracer\Trait\Brancher\DirectionMap;
use Arknet\LineReracer\Exception\IndexNotFoundException;
use Arknet\LineReracer\Exception\ParamsNotSettedException;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;

class DiagonalCollector
{
    use DirectionMap, Lengthable, Indexable, PositionCollectionable;

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

    public function hasJump(): bool
    {
        $DCC1 = $this->getFirstDiagonalCollection()->hasJump();
        $DCC2 = $this->getSecondDiagonalCollection()->hasJump();
        $DCC3 = $this->getThirdDiagonalCollection()->hasJump();
        $DCC4 = $this->getFourthDiagonalCollection()->hasJump();
        return $DCC1 || $DCC2 || $DCC3 || $DCC4;
    }

    public function getJumps(): MovementsCollection
    {
        $DCJ1 = $this->getFirstDiagonalCollection()->getJumps();
        $DCJ2 = $this->getSecondDiagonalCollection()->getJumps();
        $DCJ3 = $this->getThirdDiagonalCollection()->getJumps();
        $DCJ4 = $this->getFourthDiagonalCollection()->getJumps();
        return $DCJ1->merge($DCJ2->merge($DCJ3->merge($DCJ4)));
    }

    public function getSteps(): MovementsCollection
    {
        $DCS1 = $this->getFirstDiagonalCollection()->getSteps();
        $DCS2 = $this->getSecondDiagonalCollection()->getSteps();
        $DCS3 = $this->getThirdDiagonalCollection()->getSteps();
        $DCS4 = $this->getFourthDiagonalCollection()->getSteps();
        return $DCS1->merge($DCS2->merge($DCS3->merge($DCS4)));
    }

    private function getFirstDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->firstDiagonalCollection))
        {
            $this->firstDiagonalCollection = $this->getNewDiagonalCollection(static::DirectionNE);
        }
        return $this->firstDiagonalCollection;
    }

    private function getSecondDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->secondDiagonalCollection))
        {
            $this->secondDiagonalCollection = $this->getNewDiagonalCollection(static::DirectionSE);
        }
        return $this->secondDiagonalCollection;
    }

    private function getThirdDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->thirdDiagonalCollection))
        {
            $this->thirdDiagonalCollection = $this->getNewDiagonalCollection(static::DirectionSW);
        }
        return $this->thirdDiagonalCollection;
    }

    private function getFourthDiagonalCollection(): DiagonalCollection
    {
        if(!isset($this->fourthDiagonalCollection))
        {
            $this->fourthDiagonalCollection = $this->getNewDiagonalCollection(static::DirectionNW);
        }
        return $this->fourthDiagonalCollection;
    }

    private function continueCompute(): void
    {
        for($iterator = 1; $iterator <= $this->length; $iterator++)
        {
            $this->addElementsToDiagonal($iterator);
        }
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
        $this->addFirstElementByCoordinates($this->x+$iterator, $this->y-$iterator);
    }
    
    private function addToSecondDiagonal(int $iterator): void
    {
        $this->addSecondElementByCoordinates($this->x+$iterator, $this->y+$iterator);
    }

    private function addToThirdDiagonal(int $iterator): void
    {
        $this->addThirdElementByCoordinates($this->x-$iterator, $this->y+$iterator);
    }

    private function addToFourthDiagonal(int $iterator): void
    {
        $this->addFourthElementByCoordinates($this->x-$iterator, $this->y-$iterator);
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
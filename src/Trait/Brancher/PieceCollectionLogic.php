<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Entity\MovementCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

trait PieceCollectionLogic
{
    use DirectionMap;

    public function getPieceStep(): MovementsCollection
    {
        if($this->checkDirection())
        {
            return $this->getJustStep();
        }
        return new MovementsCollection;
    }

    public function getPieceNearestJump(): MovementsCollection
	{
		if($this->hasPieceJump())
		{
			return $this->getPieceNearestJumpCollection();
		}
		return new MovementsCollection;
	}

    public function hasPieceJump(): bool
	{
		$element = $this->getPositionCollection()->get($this->getIndex());
		$checkIsEnemy = $this->hasVector() ? $this->getVector()[0]->isEnemy($element): false;
		return (($this->countVector() >= 2 ? $this->getVector()[1] : []) instanceof Emptiness) && $checkIsEnemy;
	}

    private function checkDirection(): bool
    {
        if($this->getPositionCollection()->get($this->getIndex())->isWhite())
        {
            return $this->getDirection() == $this->directionNE || $this->getDirection() == $this->directionNW;
        }
        return $this->getDirection() == $this->directionSE || $this->getDirection() == $this->directionSW;
    }

    private function getJustStep(): MovementsCollection
    {
        $indexes = $this->convertIteratorsToIndexes([0]);
        return isset($indexes[0]) && ($this->getPositionCollection()->get($indexes[0]) instanceof Emptiness)
        ? $this->getJustStepContinue($indexes) : new MovementsCollection;
    }

    private function getJustStepContinue(array $indexes): MovementsCollection
    {
        return (new MovementsCollection())->add((new MovementCollection())->add(
            (new Movement)->setFromIndex($this->getIndex())->setToIndex($indexes[0])
        ));
    }

    private function getPieceNearestJumpCollection(): MovementsCollection
	{
		return (new MovementsCollection())->add((new MovementCollection())->add(
            (new Movement)->setFromIndex($this->getIndex())->setHitIndex(
                $this->convertIteratorsToIndexes([0])[0]
            )->setToIndex($this->convertIteratorsToIndexes([1])[0])
		));
	}
}
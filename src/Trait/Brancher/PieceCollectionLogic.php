<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\MovementCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

trait PieceCollectionLogic
{
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
		$checkIsEnemy = isset($this->getVector()[0]) ? $this->getVector()[0]->isEnemy($element): false;
		return ($this->getVector()[1] ?? [] instanceof Emptiness) && $checkIsEnemy;
	}

    private function getPieceNearestJumpCollection(): MovementsCollection
	{
		return (new MovementsCollection())->add((new MovementCollection())->add(
            (new Movement)->setFromIndex($this->getIndex())->setHitIndex(
                $this->convertIteratorsToIndexes([1])
            )->setToIndex($this->convertIteratorsToIndexes([2]))
		));
	}
}
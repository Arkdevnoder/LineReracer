<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Entity\MovementCollection;
use Arknet\LineReracer\Entity\MovementsCollection;
use Arknet\LineReracer\Trait\Utils\DiagonalCounter;

trait QueenCollectionLogic 
{
    use DiagonalCounter;

    private int $hitIterator = -1;

    public function getQueenSteps(): MovementsCollection
    {
        $emptyIndexes = $this->convertIteratorsToIndexes($this->getEmptyIteratorsAfter(0));
		return $this->getMovementsCollectionBasedOnIndexes(new MovementsCollection, $emptyIndexes);
    }

    public function getQueenNearestJumps(): MovementsCollection
	{
		$this->hasQueenJump();
		$emptyIterators = $this->getEmptyIteratorsAfter($this->hitIterator);
        $emptyIndexes = $this->convertIteratorsToIndexes($emptyIterators);
		return $this->getMovementsCollectionBasedOnIndexes(new MovementsCollection, $emptyIndexes);
	}
	
	public function hasQueenJump(): bool
	{
		for($key = 0; ($key < $this->countVector()) && (($hasJump ?? 0) == 0); $key++)
		{
			$hasJump += (int) $this->isJumpableQueenKey($key);
		}
		return (($hasJump ?? 0) > 0);
	}

    public function getEmptyIteratorsAfter(int $iterator): array
	{
		$result = [];
		$this->getEmptyIteratorsAfterContinue($result, $iterator);
		return $result;
	}

	public function getMovementsCollectionBasedOnIndexes(
		MovementsCollection $movementsCollection,
		array $emptyIndexes
	): MovementsCollection {
		foreach($emptyIndexes as $key => $index)
		{
			$this->addToMovementsCollection($movementsCollection, $index);
		}
		return $movementsCollection;
	}

	private function addToMovementsCollection(
		MovementsCollection &$movementsCollection,
		array $emptyIndex
	): void {
		$movementsCollection->add((new MovementCollection)->add(
			(new Movement())->setFromIndex($this->getIndex())->setHitIndex(
                $this->convertIteratorsToIndexes([$this->hitIterator])[0]
            )->setToIndex($emptyIndex)
		));
	}

	private function getEmptyIteratorsAfterContinue(array &$result, int $iterator): void
	{
		for($key = $iterator+1; ($key < $this->countVector()) && (($hasEmptiness ?? false) === false); $key++)
		{
			$hasEmptiness = $this->addResultIfNotEmptiness($result, $key);
		}
	}

	private function addResultIfNotEmptiness(array &$result, int $key): bool
	{
		if($this->getVector()[$key] instanceof Emptiness)
		{
			return $this->addCompleteResultIfNotEmptiness($result, $key);
		}
		return false;
	}

	private function addCompleteResultIfNotEmptiness(array &$result, int $key): bool
	{
		$result[] = $key;
		return true;
	}

	private function isJumpableQueenKey(int $key): bool
	{
		$checkFlag = $this->hasOnlyOneEnemy($this->getBetween(0, $key));
		$this->cacheHitIndex($checkFlag);
		return ($key !== 0) && ($this->getVector()[$key] instanceof Emptiness) && $checkFlag;
	}

	private function cacheHitIndex(bool $checkFlag, int $key): bool
	{
		if($this->hitIterator == -1 && $checkFlag)
		{
			$this->hitIterator = $key - 1;
		}
	}

	private function hasOnlyOneEnemy(array $elements): bool
	{
		$gameElement = $this->getPositionCollection()->get($this->getIndex());
		return ($this->countEnemies($elements, $gameElement) === 1) &&
		($this->countAllies($elements, $gameElement) === 0);
	}
}
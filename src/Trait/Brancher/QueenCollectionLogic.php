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
		$iterators = $this->getEmptyIteratorsAfter(-1);
        $emptyIndexes = $this->convertIteratorsToIndexes($iterators);
		return $this->getMovementsCollectionBasedOnIndexes(new MovementsCollection, $emptyIndexes);
    }

    public function getQueenNearestJumps(): MovementsCollection
	{
		$checkFlag = $this->hasQueenJump();
		return $checkFlag === true ? $this->getQueenNearestJumpsContinue() : new MovementsCollection;
	}

	public function getQueenNearestJumpsContinue(): MovementsCollection
	{
		$emptyIterators = $this->getEmptyIteratorsAfter($this->hitIterator);
        $emptyIndexes = $this->convertIteratorsToIndexes($emptyIterators);
		return $this->getMovementsCollectionBasedOnIndexes(new MovementsCollection, $emptyIndexes);
	}
	
	private function hasQueenJump(): bool
	{
		for($key = 0; ($key < $this->countVector()) && (($hasJump ?? 0) == 0); $key++)
		{
			$hasJump = ($hasJump ?? 0) + (int) $this->isJumpableQueenKey($key);
		}
		return (($hasJump ?? 0) > 0);
	}

    private function getEmptyIteratorsAfter(int $iterator): array
	{
		$result = [];
		$this->getEmptyIteratorsAfterContinue($result, $iterator);
		return $result;
	}

	private function getMovementsCollectionBasedOnIndexes(
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
		int $emptyIndex
	): void {
		$movementCollection = (new MovementCollection)->add($this->getMovement($emptyIndex));
		$movementsCollection->add($movementCollection);
	}

	private function getMovement(int $emptyIndex): Movement
	{
		return $this->hitIterator !== -1
		? (new Movement())->setFromIndex($this->getIndex())->setHitIndex($this->getHitIndex())->setToIndex($emptyIndex)
		: (new Movement())->setFromIndex($this->getIndex())->setToIndex($emptyIndex);
	}

	private function getHitIndex(): int
	{
		return $this->convertIteratorsToIndexes([$this->hitIterator])[0];
	}

	private function getEmptyIteratorsAfterContinue(array &$result, int $iterator): void
	{
		for($key = $iterator+1; ($key < $this->countVector()) && (($hasEmptiness ?? true) === true); $key++)
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
		$between = $this->getBetween(0, $key);
		$checkFlag = $this->hasOnlyOneEnemy($between);
		$this->cacheHitIndex($checkFlag, $key);
		return ($key !== 0) && ($this->getVector()[$key] instanceof Emptiness) && $checkFlag;
	}

	private function cacheHitIndex(bool $checkFlag, int $key): void
	{
		if($this->hitIterator == -1 && $checkFlag)
		{
			$this->hitIterator = $key - 1;
		}
	}

	private function hasOnlyOneEnemy(array $elements): bool
	{
		$gameElement = $this->getPositionCollection()->get($this->getIndex());
		$firstFlag = ($this->countEnemies($elements, $gameElement) === 1);
		$secondFlag = ($this->countAllies($elements, $gameElement) === 0);
		return $firstFlag && $secondFlag;
	}
}
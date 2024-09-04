<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Trait\Initor\Indexable;
use Arknet\LineReracer\Contracts\Entity\GameElement;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;
use Arknet\LineReracer\Trait\Collection\VectorPropertiesElement;

class DiagonalCollection implements \Iterator
{
	use Indexable, PositionCollectionable, VectorPropertiesElement;

	public function hasJump(): bool
	{
		if($this->getPositionCollection()->get($this->getIndex())->isQueen())
		{
			return $this->hasQueenJump();
		}
		return $this->hasPieceJump();
	}

	public function hasPieceJump(): bool
	{
		$element = $this->getPositionCollection()->get($this->getIndex());
		$checkIsEnemy = isset($this->getVector()[0]) ? $this->getVector()[0]->isEnemy($element): false;
		return ($this->getVector()[1] ?? [] instanceof Emptiness) && $checkIsEnemy;
	}
	
	public function hasQueenJump(): bool
	{
		foreach($this->getVector() as $key => $gameElement)
		{
			$hasJump += (int) $this->isJumpableQueenKey($key);
		}
		return (($hasJump ?? 0) > 0);
	}

	private function isJumpableQueenKey(int $key): bool
	{
		return ($key !== 0) &&
		($this->getVector()[$key] instanceof Emptiness) &&
		$this->hasOnlyOneEnemy($this->getBetween(0, $key));
	}

	private function hasOnlyOneEnemy(array $elements): bool
	{
		$gameElement = $this->getPositionCollection()->get($this->getIndex());
		return $this->countEnemies($elements, $element) === 1;
	}

	private function countEnemies(array $elements, GameElement $gameElement): int
	{
		foreach($elements as $element)
		{
			$result += (int) $element->isEnemy($gameElement);
		}
		return (int) ($result ?? 0);
	}

}
<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Trait\Initor\Indexable;
use Arknet\LineReracer\Trait\Initor\Directionable;
use Arknet\LineReracer\Trait\Brancher\DirectionMap;
use Arknet\LineReracer\Contracts\Entity\GameElement;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;
use Arknet\LineReracer\Trait\Brancher\PieceCollectionLogic;
use Arknet\LineReracer\Trait\Brancher\QueenCollectionLogic;
use Arknet\LineReracer\Trait\Collection\VectorPropertiesElement;

class DiagonalCollection implements \Iterator
{
	use Indexable;
	use Directionable;
	use PositionCollectionable;
	use VectorPropertiesElement;

	use DirectionMap;
	use QueenCollectionLogic;
	use PieceCollectionLogic;

	public function convertIteratorsToIndexes(array $emptyIterators): array
	{
		foreach($emptyIterators as $iterator)
		{
			$result[] = $this->getIndexFromIterator($this->getIndexCoordinates(), $iterator);
		}
		return $result;
	}

	public function hasJump(): bool
	{
		if($this->getPositionCollection()->get($this->getIndex())->isQueen())
		{
			return $this->hasQueenJump();
		}
		return $this->hasPieceJump();
	}

	private function getIndexFromIterator(array $coordinates, int $iterator): int
	{
		$offset = $this->multiplyOffset($this->getOffset($this->getDirection()), $iterator+1);
		return $this->getPositionCollection()->getIndexByCoordinates(
			[$offset["x"]+$coordinates["x"], $offset["y"]+$coordinates["y"]]
		);
	}

	private function getIndexCoordinates(): array
	{
		return $this->getPositionCollection()->getCoordinatesByIndex($this->getIndex());
	}
}
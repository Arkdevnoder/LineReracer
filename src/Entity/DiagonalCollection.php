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

	public function hasJump(): bool
	{
		if($this->getPositionCollection()->get($this->getIndex())->isQueen())
		{
			return $this->hasQueenJump();
		}
		return $this->hasPieceJump();
	}

	public function getJumps(): MovementsCollection
	{
		if($this->getPositionCollection()->get($this->getIndex())->isQueen())
		{
			return $this->getQueenNearestJumps();
		}
		return $this->getPieceNearestJump();
	}

	public function getSteps(): MovementsCollection
	{
		if($this->getPositionCollection()->get($this->getIndex())->isQueen())
		{
			return $this->getQueenSteps();
		}
		return $this->getPieceStep();
	}

	private function convertIteratorsToIndexes(array $emptyIterators): array
	{
		$result = [];
		$this->convertIteratorsToIndexesContinue($emptyIterators, $result);
		return $result;
	}

	private function convertIteratorsToIndexesContinue(array $emptyIterators, array &$result): void
	{
		foreach($emptyIterators as $iterator)
		{
			$this->pushIfFoundIterator($result, $iterator);
		}
	}

	private function pushIfFoundIterator(array &$result, int $iterator): void
	{
		$content = $this->iteratorConditionArray($iterator);
		if($content["condition"])
		{
			$this->pushBasedOnContent($content, $result);
		}
	}

	private function pushBasedOnContent(array $content, array &$result): void
	{
		$x = $content["coordinates"]["x"];
		$y = $content["coordinates"]["y"];
		$result[] = $this->getPositionCollection()->getIndexByCoordinates($x, $y);
	}

	private function iteratorConditionArray(int $iterator): array
	{
		$coordinates = $this->getCoordinatesOfIterator($iterator);
		return [
			"condition" => $this->getPositionCollection()->hasIndexByCoordinates($coordinates["x"], $coordinates["y"]),
			"coordinates" => $coordinates
		];
	}

	private function getCoordinatesOfIterator(int $iterator): array
	{
		$coordinates = $this->getIndexCoordinates();
		$offset = $this->multiplyOffset($this->getOffset($this->getDirection()), $iterator+1);
		return [
			"x" => $offset["x"]+$coordinates[0], "y" => $offset["y"]+$coordinates[1]
		];
	}

	private function getIndexCoordinates(): array
	{
		return $this->getPositionCollection()->getCoordinatesByIndex($this->getIndex());
	}
}
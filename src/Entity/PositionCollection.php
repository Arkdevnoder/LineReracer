<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Contracts\Entity\GameElement;
use Arknet\LineReracer\Exception\IndexNotFoundException;
use Arknet\LineReracer\Trait\Brancher\PositionInitializer;
use Arknet\LineReracer\Trait\Collection\VectorPropertiesElement;

class PositionCollection implements \Iterator
{
	use VectorPropertiesElement, PositionInitializer;

	public const RowsLength = 8;
	public const ColumnsLength = 8;
	public const BlackRows = 3;
	public const EmptyRows = 2;
	public const WhiteRows = 3;
	public const PiecesInRow = 4;

	private array $map;
	private array $reversedMap;

	public function __construct()
	{
		$this->rewind();
		$this->initializeRows();
		$this->formMaps(static::ColumnsLength, static::RowsLength);
	}

	public function getNotation(): string
	{
		$result = [];
		$this->getNotationContinue($result);
		$string = implode(",", $result ?? []);
		return $string;
	}

	private function getNotationContinue(array &$result): void
	{
		$vector = $this->getVector();
		for($j = 0; $j < count($vector); $j++)
		{
			$result[] = ($vector[$j]->getValue() == "") ? "e" : $vector[$j]->getValue();
		}
	}

	public function setNotation(string $notation): void
	{
		$this->vector = [];
		foreach(explode(",", $notation) as $element)
		{
			$this->vector[] = $element == "e" ? (new Emptiness) : (new Piece)->set($element);
		}
	}

	public function getRowsLength(): int
	{
		return static::RowsLength;
	}

	public function getColumnsLength(): int
	{
		return static::ColumnsLength;
	}

	public function getMaxDiagonalDimension(): int
	{
		return static::RowsLength - 1;
	}

	public function move(Movement $movement): void
    {
		if($movement->hasHitIndex())
		{
			$this->delete($movement->getHitIndex());
		}
        $this->swap($movement->getFromIndex(), $movement->getToIndex());
    }

	public function swap(int $key1, int $key2): object
	{
		[$this->vector[$key1], $this->vector[$key2]] = [$this->vector[$key2], $this->vector[$key1]];
		$check = $this->isIndexInEdge($key2);
		!$check ?: $this->vector[$key2]->toQueen();
		return $this;
	}

	public function isIndexInEdge(int $index): bool
	{
		$coordinates = $this->getCoordinatesByIndex($index);
		return ($this->get($index)->isWhite() && $coordinates[1] == 0)
		|| ($this->get($index)->isBlack() && $coordinates[1] == ($this->getRowsLength() - 1));
	}

	public function delete(int $key): object
	{
		unset($this->vector[$key]);
		$this->vector[$key] = (new Emptiness);
		return $this;
	}

	public function get(int $key): object
	{
		return $this->vector[$key];
	}

	public function getMap(): array
	{
		return $this->map;
	}

	public function getReversedMap(): array
	{
		return $this->reversedMap;
	}

	public function getIndexByCoordinates(int $x, int $y): int
	{
		return $this->reversedMap[$x.",".$y];
	}

	public function hasIndexByCoordinates(int $x, int $y): bool
	{
		return isset($this->reversedMap[$x.",".$y]);
	}

	public function getCoordinatesByIndex(int $position): array
	{
		if(isset($this->map[$position]))
		{
			return $this->map[$position];
		}
		throw new IndexNotFoundException;
	}

	public function getElementByCoordinates(int $x, int $y): GameElement
	{
		if($this->hasIndexByCoordinates($x, $y))
		{
			return $this->vector[$this->getIndexByCoordinates($x, $y)];
		}
		throw new IndexNotFoundException;
	}

	public function getOccupiedIndexes(): array
	{
		$result = (array) null;
		$this->actionOfGettingOccupiedVector($result);
		return $result;
	}

	public function getResultOccupiedVectorElement(array &$result, int $index): void
	{
		if(!($this->vector[$index] instanceof Emptiness))
		{
			$result[] = $index;
		}
	}

	private function actionOfGettingOccupiedVector(array &$result): void
	{
		foreach($this->vector as $index => $element)
		{
			$this->getResultOccupiedVectorElement($result, $index);
		}
	}

}
<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Contracts\Entity\GameElement;
use Arknet\LineReracer\Exception\IndexNotFoundException;
use Arknet\LineReracer\Trait\Collection\VectorPropertiesElement;

class PositionCollection implements \Iterator
{
	use VectorPropertiesElement;

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

	public function swap(int $key1, int $key2): object
	{
		[$this->vector[$key1], $this->vector[$key2]] = [$this->vector[$key2], $this->vector[$key1]];
		return $this;
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

	private function actionOfGettingOccupiedVector(array &$result): void
	{
		foreach($this->vector as $index => $element)
		{
			$this->getResultOccupiedVectorElement($result, $index);
		}
	}

	public function getResultOccupiedVectorElement(array &$result, int $index): void
	{
		if(!($this->vector[$index] instanceof Emptiness))
		{
			$result[] = $index;
		}
	}

	private function initializeRows(): void
	{
		$this->initializeVector();
		$this->initializeBlackRows();
		$this->initializeEmptyRows();
		$this->initializeWhiteRows();
	}

	private function initializeVector(): void
	{
		$this->vector = (array) null;
	}

	private function initializeBlackRows(): void
	{
		for($i = 0; $i < static::BlackRows; $i++)
		{
			$this->pushInitialBlackRow();
		}
	}

	private function initializeEmptyRows(): void
	{
		for($i = 0; $i < static::EmptyRows; $i++)
		{
			$this->pushInitialVoidRow();
		}
	}

	private function initializeWhiteRows(): void
	{
		for($i = 0; $i < static::WhiteRows; $i++)
		{
			$this->pushInitialWhiteRow();
		}
	}

	private function pushInitialBlackRow(): void
	{
		for($i = 0; $i < static::PiecesInRow; $i++)
		{
			$this->vector[] = (new Piece)->setBlackPiece();
		}
	}

	private function pushInitialWhiteRow(): void
	{
		for($i = 0; $i < static::PiecesInRow; $i++)
		{
			$this->vector[] = (new Piece)->setWhitePiece(); 
		}
	}

	private function pushInitialVoidRow(): void
	{
		for($i = 0; $i < static::PiecesInRow; $i++)
		{
			$this->vector[] = (new Emptiness); 
		}
	}

	private function formMaps(int $width, int $height): void
	{
		$this->formMap($width, $height);
		$this->formReversedMap();
	}

	private function formReversedMap(): void
	{
		foreach($this->getMap() as $index => $element)
		{
			$result[$element[0].",".$element[1]] = $index;
		}
		$this->reversedMap = $result ?? [];
	}

	private function formMap(int $width, int $height): void
	{
		for($index = 0; $index < $height; $index++)
		{
			$this->formRowMap($width, $index);
		}
	}

	private function formRowMap(int $width, int $index): void
	{
		for($selector = 0; $selector < $width; $selector++)
		{
			$this->formField($selector, $index);
		}
	}

	private function formField(int $x, int $y): void
	{
		$this->wrapFormEvenRowField($x, $y);
		$this->wrapFormNotEvenRowField($x, $y);
	}

	private function wrapFormEvenRowField(int $x, int $y): void
	{
		if($y % 2 == 0)
		{
			$this->formEvenRowField($x, $y);
		}
	}

	private function wrapFormNotEvenRowField(int $x, int $y): void
	{
		if(!($y % 2 == 0))
		{
			$this->formNotEvenRowField($x, $y);
		}
	}

	private function formEvenRowField(int $x, int $y): void
	{
		if(!($x % 2 == 0))
		{
			$this->map[] = [$x, $y];
		}
	}

	private function formNotEvenRowField(int $x, int $y): void
	{
		if($x % 2 == 0)
		{
			$this->map[] = [$x, $y];
		}
	}
}
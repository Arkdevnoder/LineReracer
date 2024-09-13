<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Entity\Emptiness;

trait PositionInitializer
{
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
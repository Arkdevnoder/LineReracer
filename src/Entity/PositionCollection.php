<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Entity\Emptiness;

class PositionCollection
{
	public const RowsLength = 8;
	public const ColumnsLength = 8;
	public const BlackRows = 3;
	public const EmptyRows = 2;
	public const WhiteRows = 3;
	public const PiecesInRow = 4;

	private array $vector;

	public function __construct(bool $hasInitialization = true)
	{
		if($hasInitialization)
		{
			$this->initializeRows();
		}
	}

	public function getVector(): array
	{
		return $this->vector;
	}

	public function setVector(array $vector): PositionCollection
	{
		$this->vector = $vector;
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
}
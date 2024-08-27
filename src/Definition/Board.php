<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Board\Action;

class Board
{

	private array $defaultPosition = [
		"b", "b", "b", "b",
		"b", "b", "b", "b",
		"b", "b", "b", "b",
		"", "", "", "",
		"", "", "", "",
		"w", "w", "w", "w",
		"w", "w", "w", "w",
		"w", "w", "w", "w"
	];

	private Collection $positionCollection;

	public function getWhitePieceString(): string
	{
		return self::WhitePiece;
	}

	public function getWhiteQueenString(): string
	{
		return self::WhiteQueen;
	}

	public function getBlackPieceString(): string
	{
		return self::BlackPiece;
	}

	public function getBlackQueenString(): string
	{
		return self::BlackQueen;
	}

	public function generateInitialPosition(): void
	{

	}
}
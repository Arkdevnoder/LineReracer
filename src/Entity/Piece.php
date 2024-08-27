<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Exception\PieceNotFoundException;

class Piece
{
	private const WhitePiece = "w";
	private const WhiteQueen = "W";
	private const BlackPiece = "b";
	private const BlackQueen = "B";

	private string $value;

	public function set(string $piece): this
	{
		$this->setValue($piece);
		return $this;
	}

	public function get(): string
	{
		return $this->value;
	}

	public function isPiece(string $piece): bool
	{
		return in_array($piece, $this->getAllPieces());
	}

	public function toQueen(): this
	{
		$this->value = strtoupper($this->value);
		return $this;
	}

	private function setValue(string $piece): void
	{
		if(!$this->isPiece($piece))
		{
			throw new PieceNotFoundException;
		}
		$this->value = $piece;
	}

	private function getAllPieces(): array
	{
		return [
			static::WhitePiece, static::WhiteQueen,
			static::BlackPiece, static::BlackQueen
		];
	}
}
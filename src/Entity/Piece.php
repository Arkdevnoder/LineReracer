<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Contracts\Entity\GameElement;
use Arknet\LineReracer\Exception\PieceNotFoundException;

class Piece implements GameElement
{
	private const WhitePiece = "w";
	private const WhiteQueen = "W";
	private const BlackPiece = "b";
	private const BlackQueen = "B";

	private string $value;

	public function setWhitePiece(): Piece
	{
		$this->value = static::WhitePiece;
		return $this;
	}

	public function setBlackPiece(): Piece
	{
		$this->value = static::BlackPiece;
		return $this;
	}

	public function setWhiteQueen(): Piece
	{
		$this->value = static::WhiteQueen;
		return $this;
	}

	public function setBlackQueen(): Piece
	{
		$this->value = static::BlackQueen;
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

	public function toQueen(): Piece
	{
		$this->value = strtoupper($this->value);
		return $this;
	}

	public function set(string $piece): Piece
	{
		$this->setValue($piece);
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
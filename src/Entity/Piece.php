<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Contracts\Entity\GameElement;
use Arknet\LineReracer\Exception\PieceNotFoundException;

class Piece implements GameElement
{
	public const WhitePiece = "w";
	public const WhiteQueen = "W";
	public const BlackPiece = "b";
	public const BlackQueen = "B";

	private string $value;

	public function isWhite(): bool
	{
		return strtolower($this->getValue()) == static::WhitePiece;
	}

	public function isBlack(): bool
	{
		return !$this->isWhite();
	}

	public function isEnemy(GameElement $gameElement): bool
	{
		return (strtolower($gameElement->getValue()) !== strtolower($this->value)) &&
		$this->isPiece($gameElement->getValue());
	}

	public function isAlly(GameElement $gameElement): bool
	{
		return strtolower($gameElement->getValue()) == strtolower($this->value);
	}

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

	public function isQueen(): bool
	{
		return ($this->value == static::WhiteQueen) || ($this->value == static::BlackQueen);
	}

	public function get(): string
	{
		return $this->value;
	}

	public function getValue(): string
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

	public function toPiece(): Piece
	{
		$this->value = strtolower($this->value);
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
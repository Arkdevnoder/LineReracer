<?php

namespace Arknet\LineReracer\Definition;

class Turn
{
	public const White = "white";
	public const Black = "black";
	public const MaximumNoBeatsMoves = 30;

	private string $value;
	private int $noBeatsMoves;

	public function __construct()
	{
		$this->setWhite();
		$this->setNullNoBeatsMoves();
	}

	public function setNoBeatsMoves(int $moves): Turn
	{
		$this->noBeatsMoves = $moves;
		return $this;
	}

	public function setWhite(): Turn
	{
		$this->value = static::White;
		return $this;
	}

	public function setBlack(): Turn
	{
		$this->value = static::Black;
		return $this;
	}

	public function setValue(string $value): Turn
	{
		$this->value = $value;
		return $this;
	}

	public function isWhite(): bool
	{
		return $this->value == static::White;
	}

	public function isBlack(): bool
	{
		return $this->value == static::Black;
	}

	public function toggle(): void
	{
		$this->isWhite() ? $this->setBlack() : $this->setWhite();
	}

	public function incrementNoBeatsMoves(): Turn
	{
		$this->noBeatsMoves = $this->noBeatsMoves + 1;
		return $this;
	}

	public function setNullNoBeatsMoves(): Turn
	{
		$this->setNoBeatsMoves(0);
		return $this;
	}

	public function getNoBeatsMoves(): int
	{
		return $this->noBeatsMoves;
	}

	public function isDraw(): int
	{
		return $this->noBeatsMoves > static::MaximumNoBeatsMoves;
	}

	public function getOppositeValue(): string
	{
		return $this->isWhite() ? static::Black : static::White;
	}

	public function getValue(): string
	{
		return $this->value;
	}
}
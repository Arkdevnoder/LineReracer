<?php

namespace Arknet\LineReracer\Definition;

class Turn
{
	public const White = "white";
	public const Black = "black";

	private string $value;

	public function __construct()
	{
		$this->setWhite();
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

	public function getValue(): string
	{
		return $this->value;
	}
}
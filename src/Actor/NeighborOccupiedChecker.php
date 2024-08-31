<?php

namespace Arknet\LineReracer\Actor;

class NeightborOccupiedChecker
{
	private PositionCollection $positionCollection;

	private int $x;

	private int $y;

	private int $nx;

	private int $px;

	private int $ny;

	private int $py;

	public function setX(int $x): object
	{
		$this->x = $x;
		$this->nx = $x - 1;
		$this->px = $x + 1;
		return $this;
	}

	public function setY(int $y): object
	{
		$this->y = $y;
		$this->ny = $y - 1;
		$this->py = $y + 1;
		return $this;
	}

	public function setPositionCollection(PositionCollection $positionCollection): object
	{
		$this->positionCollection = $positionCollection;
		return $this;
	}

	public function check(): bool
	{
	}
}
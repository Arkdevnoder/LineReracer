<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Exception\IndexNotFoundException;

class NeighborOccupiedChecker
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
		$c1 = strtolower($this->getGameElementCenter());
		$c2 = strtolower($this->getGameElementFirst());
		$c3 = strtolower($this->getGameElementSecond());
		$c4 = strtolower($this->getGameElementThird());
		return !(($c1 == $c2) && ($c2 == $c3) && ($c3 == $c4) && ($c4 == strtolower($this->getGameElementFourth())));
	}

	private function getGameElementCenter(): string
	{
		try {
			return $this->positionCollection->getElementByCoordinates($this->x, $this->y)->get();
		} catch(IndexNotFoundException $exception) {
			return (string) null;
		}
	}

	private function getGameElementFirst(): string
	{
		try {
			return $this->positionCollection->getElementByCoordinates($this->nx, $this->py)->get();
		} catch(IndexNotFoundException $exception) {
			return $this->positionCollection->getElementByCoordinates($this->x, $this->y)->get();
		}
	}

	private function getGameElementSecond(): string
	{
		try {
			return $this->positionCollection->getElementByCoordinates($this->px, $this->py)->get();
		} catch(IndexNotFoundException $exception) {
			return $this->positionCollection->getElementByCoordinates($this->x, $this->y)->get();
		}
	}

	private function getGameElementThird(): string
	{
		try {
			return $this->positionCollection->getElementByCoordinates($this->nx, $this->ny)->get();
		} catch(IndexNotFoundException $exception) {
			return $this->positionCollection->getElementByCoordinates($this->x, $this->y)->get();
		}
	}

	private function getGameElementFourth(): string
	{
		try {
			return $this->positionCollection->getElementByCoordinates($this->px, $this->ny)->get();
		} catch(IndexNotFoundException $exception) {
			return $this->positionCollection->getElementByCoordinates($this->x, $this->y)->get();
		}
	}
}
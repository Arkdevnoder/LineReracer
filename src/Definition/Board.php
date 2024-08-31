<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Board\Action;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

class Board implements Action
{
	private PositionCollection $positionCollection;

	public function __construct(PositionCollection $positionCollection)
	{
		$this->positionCollection = $positionCollection;
	}

	public function getPositionCollection(): PositionCollection
	{
		return $this->positionCollection;
	}

	public function getPossibleMoves(): MovementsCollection
	{
		return $this->getTolerance()->getMovementsCollection();
	}

	private function getTolerance(): Tolerance
	{
		$positionCollection = $this->getPositionCollection();
		new Tolerance($positionCollection, $positionCollection->getOccupiedIndexes());
	}
}
<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Actor\Tolerance;
use Arknet\LineReracer\Contracts\Board\Action;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

class Board implements Action
{
	private Game $game;
	private PositionCollection $positionCollection;

	public function __construct(PositionCollection $positionCollection)
	{
		$this->positionCollection = $positionCollection;
	}

	public function setGame(Game $game): Board
	{
		$this->game = $game;
		return $this;
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
		return (new Tolerance($positionCollection, $positionCollection->getOccupiedIndexes()))->setGame($this->game);
	}
}
<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Definition\Game;
use Arknet\LineReracer\Definition\Turn;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

class Tolerance
{	
	private Game $game;
	private array $occupiedIndexes;
	private array $freeIndexes;
	private PositionCollection $positionCollection;
	private MovementsCollection $movementsCollection;
	private NeighborOccupiedChecker $neighborOccupiedChecker;

	public function __construct(
		PositionCollection $positionCollection,
		array $occupiedIndexes
	) {
		$this->occupiedIndexes = $occupiedIndexes;
		$this->positionCollection = $positionCollection;
		$this->movementsCollection = new MovementsCollection;
		$this->neighborOccupiedChecker = (new NeighborOccupiedChecker)
		->setPositionCollection($this->positionCollection);
	}

	private function getGame(): Game
	{
		return $this->game;
	}

	public function setGame(Game $game): Tolerance
	{
		$this->game = $game;
		return $this;
	}

	public function getMovementsCollection(): MovementsCollection
	{
		foreach($this->occupiedIndexes as $index)
		{
			$this->fieldComputing($index);
		}
		var_dump($this->freeIndexes);
		return $this->movementsCollection;
	}

	private function fieldComputing(int $index): void
	{
		$coordinates = $this->positionCollection->getCoordinatesByIndex($index);
		$this->continueFieldComputing($coordinates);
	}

	private function continueFieldComputing(array $coordinates): void
	{
		$this->continueComputing($coordinates[0], $coordinates[1]);
	}

	private function continueComputing(int $x, int $y): void
	{
		$index = $this->positionCollection->getIndexByCoordinates($x, $y);
		if($this->neighborOccupiedChecker->setX($x)->setY($y)->check() && $this->isIndexInTurn($index))
		{
			$this->freeIndexes[] = $index;
		}
	}

	private function isIndexInTurn(int $index): bool
	{
		if($this->getValue($index) == Piece::BlackPiece || $this->getValue($index) == Piece::BlackQueen)
		{
			return $this->getGame()->getTurn()->getValue() == Turn::Black;
		}
		return $this->getGame()->getTurn()->getValue() == Turn::White;
	}

	private function getValue(int $index): string
	{
		return $this->positionCollection->get($index)->getValue();
	}
}
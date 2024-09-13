<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Definition\Game;
use Arknet\LineReracer\Definition\Turn;
use Arknet\LineReracer\Trait\Initor\Gameable;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

class Tolerance
{	
	use Gameable;

	private array $occupiedIndexes;
	private array $freeIndexes;
	private array $stepsIndexes;
	private array $jumpingIndexes;
	public PositionCollection $positionCollection;
	private MovementsCollection $movementsCollection;
	private NeighborOccupiedChecker $neighborOccupiedChecker;

	public function __construct(
		PositionCollection $positionCollection,
		array $occupiedIndexes
	) {
		$this->occupiedIndexes = $occupiedIndexes;
		$this->positionCollection = $positionCollection;
		$this->neighborOccupiedChecker = (new NeighborOccupiedChecker)
		->setPositionCollection($this->positionCollection);
	}

	public function getMovementsCollection(): MovementsCollection
	{
		$this->generateFreeIndexes();
		$this->generateJumpingIndexes();
		$this->generateStepsIndexes();
		return empty($this->jumpingIndexes) ? $this->getStepsMoves() : $this->getJumpsMoves();
	}

	private function getStepsMoves(): MovementsCollection
	{
		return (new StepsMoveCalculator)->setIndexes($this->stepsIndexes)
		->setPositionCollection($this->positionCollection)->getMovementsCollection();
	}

	private function getJumpsMoves(): MovementsCollection
	{
		return (new JumpsMoveCalculator)->setIndexes($this->jumpingIndexes)
		->setPositionCollection($this->positionCollection)->getMovementsCollection();
	}

	private function generateStepsIndexes(): void
	{
		$this->stepsIndexes = array_diff($this->freeIndexes ?? [], $this->jumpingIndexes ?? []);
	}

	private function generateFreeIndexes(): void
	{
		foreach($this->occupiedIndexes as $index)
		{
			$this->fieldComputing($index);
		}
	}

	private function generateJumpingIndexes(): void
	{
		$this->jumpingIndexes = $this->getFreeToJumpingConvertor()->transform();
	}

	private function getFreeToJumpingConvertor(): FreeToJumpingConvertor
	{
		return (new FreeToJumpingConvertor())->setGame($this->getGame())
		->setPositionCollection($this->positionCollection)->setFreeIndexes($this->freeIndexes ?? []);
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
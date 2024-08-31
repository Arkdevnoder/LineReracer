<?php

namespace Arknet\LineReracer\Actor;

use Arknet\LineReracer\Entity\Piece;
use Arknet\LineReracer\Entity\MovementsCollection;

class Tolerance
{	
	private array $occupiedIndexes;
	private PositionCollection $positionCollection;
	private MovementsCollection $movementsCollection;

	public function __construct(
		PositionCollection $positionCollection,
		array $occupiedIndexes
	) {
		$this->occupiedIndexes = $occupiedIndexes;
		$this->positionCollection = $positionCollection;
		$this->movementsCollection = new MovementsCollection;
	}

	public function getMovementsCollection(): MovementsCollection
	{
		foreach($this->occupiedIndexes as $index)
		{
			$this->fieldComputing($index);
		}
		return $this->movementsCollection;
	}

	private function fieldComputing(int $index): void
	{
		$element = $this->positionCollection->get($index);
		$coordinates = $this->positionCollection->getCoordinatesByIndex($index);
		$this->continueFieldComputing($element, $coordinates);
	}

	private function continueFieldComputing(Piece $piece, array $coordinates): bool
	{
		if(ctype_upper($piece->get()))
		{
			return $this->wrapOfContinuePieceFieldComputing($piece, $coordinates);
		}
		return $this->wrapOfContinueQueenFieldComputing($piece, $coordinates);
	}

	private function wrapOfContinuePieceFieldComputing(Piece $piece, array $coordinates): bool
	{
		$this->continuePieceFieldComputing($piece, $coordinates);
		return true;
	}

	private function wrapOfContinueQueenFieldComputing(Piece $piece, array $coordinates): bool
	{
		$this->continueQueenFieldComputing($piece, $coordinates);
		return true;
	}

	private function continuePieceFieldComputing(Piece $piece, array $coordinates): void
	{
		
	}

	private function continueQueenFieldComputing(Piece $piece, array $coordinates): void
	{

	}
}
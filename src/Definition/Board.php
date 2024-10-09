<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Actor\Tolerance;
use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Trait\Initor\Gameable;
use Arknet\LineReracer\Contracts\Board\Action;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

class Board implements Action
{
	use Gameable;

	private PositionCollection $positionCollection;
	private MovementsCollection $currentPossibleMoves;

	public function __construct(PositionCollection $positionCollection)
	{
		$this->positionCollection = $positionCollection;
		$this->currentPossibleMoves = new MovementsCollection;
	}

	public function getPositionCollection(): PositionCollection
	{
		return $this->positionCollection;
	}

	public function getPossibleMoves(): MovementsCollection
	{
		$tolerance = $this->getTolerance();
		$moves = $tolerance->getMovementsCollection();
		$this->currentPossibleMoves = $moves;
		return $this->currentPossibleMoves;
	}

	public function getPaginatedPossibleMovesArray(int $offset, int $length): array
	{
		return array_slice($this->getPossibleMoves()->getArray(), $offset, $length, true);
	}

	public function display(): void
	{
		(new Displayer)->setPositionCollection($this->getPositionCollection())->out();
	}

	public function displayWithMoves(): void
	{
		echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
		(new Displayer)->setPositionCollection($this->getPositionCollection())
		->setEvaluator($this->getGame()->getEvaluator())->setTurn($this->getGame()->getTurn())->out();
		$this->getGame()->isDraw() ?: $this->getPossibleMoves()->display();
		echo PHP_EOL;
	}

	public function moveByIndex(int $index): void
	{
		$checker = $this->isMovementHasAttack($index);
		$this->moveByIndexContinue($index);
		$this->getGame()->getHistory()->addToList($this->getGame()->getNotation());
		$checker ? $this->nullNoBeats() : $this->getGame()->getTurn()->incrementNoBeatsMoves();
	}

	public function getCurrentPossibleMoves(): MovementsCollection
	{
		return !($this->currentPossibleMoves->isEmpty()) ? $this->currentPossibleMoves : $this->getPossibleMoves();
	}

	public function isMovementHasAttack(int $index): bool
	{
		$vector = $this->getPossibleMoves()->getVector();
		return $this->getPossibleMoves()->getVector()[$index - 1]->getVector()[0]->hasHitIndex();
	}

	public function moveByIndexContinue(int $index): void
	{
		foreach($this->getPossibleMoves()->getVector()[$index - 1]->getVector() as $movement)
		{
			$this->applyMovement($movement);
		}
		$this->setExtraBoardProperties();
	}

	public function nullNoBeats(): void
	{
		$this->getGame()->getTurn()->setNoBeatsMoves(0);
	}

	private function setExtraBoardProperties(): void
	{
		$this->currentPossibleMoves = new MovementsCollection;
		$this->getGame()->getTurn()->toggle();
	}

	private function applyMovement(Movement $movement): void
	{
		$this->getPositionCollection()->move($movement);
	}

	private function getTolerance(): Tolerance
	{
		$positionCollection = $this->getPositionCollection();
		return (new Tolerance($positionCollection, $positionCollection->getOccupiedIndexes()))->setGame($this->game);
	}
}
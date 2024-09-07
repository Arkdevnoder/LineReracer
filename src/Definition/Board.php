<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Actor\Tolerance;
use Arknet\LineReracer\Entity\Movement;
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
		$this->currentPossibleMoves = $this->getTolerance()->getMovementsCollection();
		return $this->currentPossibleMoves;
	}

	public function display(): void
	{
		(new Displayer)->setPositionCollection($this->getPositionCollection())->out();
	}

	public function displayWithMoves(): void
	{
		//echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
		(new Displayer)->setPositionCollection($this->getPositionCollection())->out();
		$this->getPossibleMoves()->display();
		echo PHP_EOL;
	}

	public function moveByIndex(int $index): void
	{
		$this->moveByIndexContinue($index);
		$this->getGame();
	}

	public function getCurrentPossibleMoves(): MovementsCollection
	{
		return !($this->currentPossibleMoves->isEmpty()) ? $this->currentPossibleMoves : $this->getPossibleMoves();
	}

	public function moveByIndexContinue(int $index): void
	{
		foreach($this->getCurrentPossibleMoves()->getVector()[$index - 1]->getVector() as $movement)
		{
			$this->applyMovement($movement);
		}
		$this->setExtraBoardProperties();
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
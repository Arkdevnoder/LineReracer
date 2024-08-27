<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Board\Action;
use Arknet\LineReracer\Entity\PositionCollection;

class Board
{
	private Collection $positionCollection;

	public function __construct(\PositionCollection $positionCollection)
	{
		$this->positionCollection = $positionCollection;
	}

	public function getPossibleMoves(): PositionCollection
	{
		
	}

	private function generateInitialPosition(): void
	{

	}
}
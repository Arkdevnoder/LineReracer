<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Definition\Board;
use Arknet\LineReracer\Definition\Engine;
use Arknet\LineReracer\Definition\Movement;
use Arknet\LineReracer\Definition\Displayer;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Contracts\Registrator\Container\Merger;

class Game implements Merger
{

	public function getBoard(): Board
	{
		return (new Board($this->getPositionCollection()));
	}

	public function getEngine(): Engine
	{
		return (new Engine);
	}

	public function getDisplayer(): Displayer
	{
		return (new Displayer);
	}

	public function getMovement(): Movement
	{
		return (new Movement);
	}

	private function getPositionCollection(): PositionCollection
	{
		return new PositionCollection(true);
	}

}
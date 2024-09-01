<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Definition\Board;
use Arknet\LineReracer\Definition\Engine;
use Arknet\LineReracer\Definition\Displayer;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Contracts\Registrator\Container\Merger;

class Game implements Merger
{
	private ServiceContainer $serviceContainer;

	public function __construct()
	{
		$this->serviceContainer = new ServiceContainer();
		$this->setBoard();
		$this->serviceContainer->set("engine", new Engine());
		$this->serviceContainer->set("turn", new Turn());
		$this->serviceContainer->set("displayer", new Displayer());
	}

	public function getBoard(): Board
	{
		return $this->getServiceContainer()->get("board");
	}

	public function getEngine(): Engine
	{
		return $this->getServiceContainer()->get("engine");
	}

	public function getDisplayer(): Displayer
	{
		return $this->getServiceContainer()->get("displayer");
	}

	public function getTurn(): Turn
	{
		return $this->getServiceContainer()->get("turn");
	}

	private function setBoard(): Game
	{
		$this->serviceContainer->set("board", (new Board($this->getPositionCollection()))->setGame($this));
		return $this;
	}

	private function getPositionCollection(): PositionCollection
	{
		return new PositionCollection();
	}

	private function getServiceContainer(): ServiceContainer
	{
		return $this->serviceContainer;
	}
}
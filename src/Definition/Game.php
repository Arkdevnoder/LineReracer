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
		$this->serviceContainer->set("board", new Board($this->getPositionCollection()));
		$this->serviceContainer->set("engine", new Engine());
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

	private function getPositionCollection(): PositionCollection
	{
		return new PositionCollection();
	}

	private function getServiceContainer(): ServiceContainer
	{
		return $this->serviceContainer;
	}
}
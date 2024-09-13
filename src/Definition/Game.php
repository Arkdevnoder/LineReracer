<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Contracts\Registrator\Container\Merger;

class Game implements Merger
{
	private ServiceContainer $serviceContainer;

	public function __construct()
	{
		$this->serviceContainer = new ServiceContainer();
		$this->setEnvironment();
		$this->setBoard();
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

	public function getEvaluator(): Evaluator
	{
		return $this->getServiceContainer()->get("evaluator");
	}

	public function isOver(): bool
	{
		return $this->getBoard()->getCurrentPossibleMoves()->countVector() === 0;
	}

	private function setEnvironment(): void
	{
		$this->serviceContainer->set("turn", new Turn());
		$this->serviceContainer->set("displayer", new Displayer());
		$this->serviceContainer->set("engine", (new Engine())->setGame($this));
		$this->serviceContainer->set("evaluator", (new Evaluator())->setGame($this));
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
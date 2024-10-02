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
		return $this->getBoard()->getCurrentPossibleMoves()->countVector() === 0
		|| $this->getTurn()->isDraw();
	}

	public function isDraw(): bool
	{
		return $this->getTurn()->isDraw();
	}

	public function getNotation(): string
	{
		return $this->getTurn()->getValue()."-".$this->getTurn()->getNoBeatsMoves()."|"
		.$this->getBoard()->getPositionCollection()->getNotation();
	}

	public function getMoves(): array
	{
		return $this->getBoard()->getPossibleMoves()->getArray();
	}

	public function setMove(): object
	{
		$this->getBoard()->moveByIndex((int) $move);
		return $this;
	}

	public function getEngineMoves(): array
	{
		return $this->getEngine()->compute()->getResult();
	}

	public function setNotation(string $notation): object
	{
		$parts = explode("|", $notation);
		$this->getBoard()->getPositionCollection()->setNotation($parts[1]);
		$turn = explode("-", $parts[0]);
		$this->getTurn()->setValue($turn[0])->setNoBeatsMoves($turn[1]);
		return $this;
	}

	private function setEnvironment(): void
	{
		$this->serviceContainer->set("turn", new Turn());
		$this->serviceContainer->set("displayer", new Displayer());
		$this->serviceContainer->set("history", new History());
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
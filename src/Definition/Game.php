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
		$this->getHistory()->addToList($this->getNotation());
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

	public function getHistory(): History
	{
		return $this->getServiceContainer()->get("history");
	}

	public function getEvaluator(): Evaluator
	{
		return $this->getServiceContainer()->get("evaluator");
	}

	public function isOver(): bool
	{
		$condition1 = $this->getBoard()->getCurrentPossibleMoves()->countVector() === 0;
		$condition2 = $this->isDraw();
		return $condition1 || $condition2;
	}

	public function isDraw(): bool
	{
		$condition1 = $this->getTurn()->isDraw();
		$condition2 = $this->getHistory()->isDraw();
		return $condition1 || $condition2;
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

	public function getStringMoves(): array
	{
		return $this->getBoard()->getPossibleMoves()->getStringArray();
	}

	public function setMove(int $move): object
	{
		$this->getBoard()->moveByIndex((int) $move);
		return $this;
	}

	public function getEngineMoves(): array
	{
		return $this->getEngine()->compute()->getResult();
	}

	public function getEngineMove(): int
	{
		$hints = $this->getEngineMoves();
		return empty($hints) ? -1 : array_search(min($hints), $hints)+1;
	}

	public function setNotation(string $notation): object
	{
		$parts = explode("|", $notation);
		$this->getBoard()->getPositionCollection()->setNotation($parts[1]);
		$turn = explode("-", $parts[0]);
		$this->getTurn()->setValue($turn[0])->setNoBeatsMoves($turn[1]);
		return $this;
	}

	public function display(): void
	{
		$this->getBoard()->displayWithMoves();
	}

	public function consoleCycle(): void
	{
		$this->display();
        $this->setMove(readline("Enter move: "));
		$move = $this->getEngineMove();
        $move == -1 ?: $this->setMove($move);
	}

	public function consoleGameOver(): void
	{
		$this->display();
		echo $this->isDraw() ? "Draw!" : $this->getTurn()->getOppositeValue()." wins!";
		echo PHP_EOL.PHP_EOL;
	}

	public function setHistoryNotation(string $notation): object
	{
		$this->getHistory()->setNotation($notation);
		return $this;
	}

	public function getHistoryNotation(): string
	{
		return $this->getHistory()->getNotation();
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
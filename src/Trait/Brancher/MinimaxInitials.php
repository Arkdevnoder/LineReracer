<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Definition\Turn;
use Arknet\LineReracer\Definition\Board;
use Arknet\LineReracer\Trait\Initor\Gameable;
use Arknet\LineReracer\Entity\PositionCollection;
use Arknet\LineReracer\Entity\MovementsCollection;

trait MinimaxInitials
{
    use Gameable;

    public const Depth = 4;
    public const SurvivalRatio = -1000;

    private array $result;

    private int $plusBigValue;

	private int $minusBigValue;

    public function __construct()
	{
		$this->plusBigValue = 1000000;
		$this->minusBigValue = -1000000;
	}

    public function getResult(): array
	{
		return $this->result;
	}

    public function getTurn(): Turn
    {
        return $this->getGame()->getTurn();
    }

    private function addResult(int $ratio): object
    {
        $this->result[] = $ratio;
        return $this;
    }

    private function flushResult(): object
    {
        $this->result = [];
        return $this;
    }

    private function getPossibleMoves(): MovementsCollection
    {
        return $this->getGame()->getBoard()->getPossibleMoves();
    }

    private function getInitialMinimaxArray(): array
	{
		return ["alpha" => $this->getMinusBigValue(), "beta" => $this->getPlusBigValue(), "depth" => static::Depth];
	}

	private function getDecreasedMinimaxArray(array $parameters): array
	{
		return ["alpha" => $parameters["alpha"], "beta" => $parameters["beta"], "depth" => $parameters["depth"] - 1];
	}

    private function getDepth(): int
	{
		return $this->depth;
	}

	private function getPlusBigValue(): int
	{
		return $this->plusBigValue;
	}

	private function getMinusBigValue(): int
	{
		return $this->minusBigValue;
	}

    private function getPositionCollection(): PositionCollection
	{
		return $this->getGame()->getBoard()->getPositionCollection();
	}

    private function getRatio(): int
    {
        return $this->getGame()->getEvaluator()->getRatio();
    }

    private function getBoard(): Board
    {   
        return $this->getGame()->getBoard();
    }
}
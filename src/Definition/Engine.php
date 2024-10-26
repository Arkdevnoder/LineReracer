<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Entity\MovementCollection;
use Arknet\LineReracer\Trait\Brancher\MinimaxInitials;

class Engine
{
	use MinimaxInitials;

	private $computerIterator = 0; 

	public function compute(): object
	{
		$this->getContinueContinue();
		return $this;
	}

	private function increaseComputerIterator(): void
	{
		$this->computerIterator++;
	}

	private function flushComputerIterator(): void
	{
		$this->computerIterator = 0;
	}

	private function reverseResult(): void
	{
		foreach($this->result as $key => $value)
		{
			$this->result[$key] *= -1;
		}
	}

	private function getContinueContinue(): void
	{
		$this->flushResult();
		foreach($this->getPossibleMoves() as $key => $movementCollection)
		{
			$this->processingRoot($movementCollection);
		}
	}

	private function processingRoot(MovementCollection $movementCollection): void
	{
		$history = $this->getHistory();
		$this->moveByMovementCollection($movementCollection);
		$this->addRatioByHistory($history);
		$this->flushComputerIterator();
		$this->undo($history);
	}

	private function addRatioByHistory(array $history): void
	{
		$ratio = $this->minimaxAlphaBeta($this->getInitialMinimaxArray(), $history);
		$benefit = $this->getBenefitByHistory($history, $ratio);
		$this->addResult($ratio+$benefit);
	}

	private function getBenefitByHistory(array $history, int $ratio): int
	{
		$isWinningByOpposite = ($history["turn"] == "white" && $ratio < -static::SurvivalRatio)
		|| ($history["turn"] == "black" && $ratio > static::SurvivalRatio);
		$computerRatio = $history["turn"] == "white" ? $this->computerIterator : -$this->computerIterator;
		return $isWinningByOpposite ? $computerRatio : 0;
	}

	private function minimaxAlphaBeta(array $parameters, array $history): int
	{
		$this->increaseComputerIterator();

		if($parameters["depth"] === 0)
		{
			return $this->getRatio();
		}

		$moves = $this->getBoard()->getPossibleMoves();

		if($this->getTurn()->isWhite())
		{
			$bestEvaluation = $this->getMinusBigValue();
			foreach($moves as $movementCollection)
			{
				$this->moveByMovementCollection($movementCollection);
				$newHistory = $this->getHistory();
				$bestEvaluation = max($bestEvaluation, $this->minimaxAlphaBeta(
					$this->getDecreasedMinimaxArray($parameters), $newHistory
				));
				$this->undo($history);

				if($bestEvaluation > $parameters["beta"])
				{
					return $bestEvaluation;
				}
				$parameters["alpha"] = max($parameters["alpha"], $bestEvaluation);
			}
		} else {
			$bestEvaluation = $this->getPlusBigValue();
			foreach($moves as $movementCollection)
			{	
				$this->moveByMovementCollection($movementCollection);
				$newHistory = $this->getHistory();
				$bestEvaluation = min($bestEvaluation, $this->minimaxAlphaBeta(
					$this->getDecreasedMinimaxArray($parameters), $newHistory
				));
				$this->undo($history);

				if($bestEvaluation < $parameters["alpha"])
				{
					return $bestEvaluation;
				}
				$parameters["beta"] = min($parameters["beta"], $bestEvaluation);
			}
		}

		return $bestEvaluation;
	}

	private function moveByMovementCollection(MovementCollection $movementCollection): void
	{
		$this->moveByMovementCollectionContinue($movementCollection);
		$this->getTurn()->toggle();
	}

	private function moveByMovementCollectionContinue(MovementCollection $movementCollection): void
	{
		foreach($movementCollection as $movement)
		{
			$this->getPositionCollection()->move($movement);
		}
	}

	private function undo(array $previous): void
	{
		if(!empty($previous))
		{
			$this->getPositionCollection()->setNotation($previous["notation"]);
			$this->getTurn()->setValue($previous["turn"]);
		}	
	}

	private function getHistory(): array
	{
		$positionCollection = $this->getPositionCollection()->getNotation();
		$turn = $this->getTurn()->getValue();
		return ["notation" => $positionCollection, "turn" => $turn];
	}
}
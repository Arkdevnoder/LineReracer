<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Entity\Movement;
use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Entity\MovementCollection;
use Arknet\LineReracer\Trait\Brancher\MinimaxInitials;

class Engine
{
	use MinimaxInitials;

	public function compute(): object
	{
		$this->getContinueContinue();
		$this->reverseResult();
		return $this;
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
		foreach($this->getPossibleMoves() as $movementCollection)
		{
			$this->processingRoot($movementCollection);
		}
	}

	private function processingRoot(MovementCollection $movementCollection): void
	{
		$history = $this->getHistory();
		$this->moveByMovementCollection($movementCollection);
		$this->addResult($this->minimaxAlphaBeta($this->getInitialMinimaxArray(), $history));
		$this->undo($history);
	}

	private function minimaxAlphaBeta(array $parameters, array $history): int
	{
		if($parameters["depth"] === 0)
		{
			return -$this->getRatio();
		}

		$moves = $this->getBoard()->getPossibleMoves();

		if($this->getTurn()->isWhite())
		{
			$bestEvaluation = $this->getPlusBigValue();
			foreach($moves as $movementCollection)
			{	
				$this->moveByMovementCollection($movementCollection);
				$newHistory = $this->getHistory();
				$bestEvaluation = min($bestEvaluation, $this->minimaxAlphaBeta(
					$this->getDecreasedMinimaxArray($parameters), $newHistory
				));
				$this->undo($history);
				$parameters["beta"] = min($parameters["beta"], $bestEvaluation);
				if($parameters["beta"] <= $parameters["alpha"])
				{
					return $bestEvaluation;
				}
			}
		} else {
			$bestEvaluation = $this->getMinusBigValue();
			foreach($moves as $movementCollection)
			{
				$this->moveByMovementCollection($movementCollection);
				$newHistory = $this->getHistory();
				$bestEvaluation = max($bestEvaluation, $this->minimaxAlphaBeta(
					$this->getDecreasedMinimaxArray($parameters), $newHistory
				));
				$this->undo($history);
				$parameters["alpha"] = max($parameters["alpha"], $bestEvaluation);
				if($parameters["beta"] <= $parameters["alpha"])
				{
					return $bestEvaluation;
				}
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
<?php

namespace Arknet\LineReracer\Trait\Brancher;

use Arknet\LineReracer\Contracts\Entity\GameElement;

trait DiagonalCounter
{
    private function countEnemies(array $elements, GameElement $gameElement): int
	{
		foreach($elements as $element)
		{
			$result += (int) $gameElement->isEnemy($element);
		}
		return (int) ($result ?? 0);
	}

	private function countAllies(array $elements, GameElement $gameElement): int
	{
		foreach($elements as $element)
		{
			$result += (int) $gameElement->isAlly($element);
		}
		return (int) ($result ?? 0);
	}
}
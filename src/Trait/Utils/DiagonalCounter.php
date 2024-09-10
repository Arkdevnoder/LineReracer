<?php

namespace Arknet\LineReracer\Trait\Utils;

use Arknet\LineReracer\Contracts\Entity\GameElement;

trait DiagonalCounter
{
    private function countEnemies(array $elements, GameElement $gameElement): int
	{
		foreach($elements as $element)
		{
			$result = ($result ?? 0) + (int) $gameElement->isEnemy($element);
		}
		return (int) ($result ?? 0);
	}

	private function countAllies(array $elements, GameElement $gameElement): int
	{
		foreach($elements as $element)
		{
			$result = ($result ?? 0) + (int) $gameElement->isAlly($element);
		}
		return (int) ($result ?? 0);
	}
}
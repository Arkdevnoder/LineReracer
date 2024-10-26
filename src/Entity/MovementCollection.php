<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Trait\Collection\VectorPropertiesElement;

class MovementCollection implements \Iterator
{
	use VectorPropertiesElement;

	public function getString(): string
	{
		foreach($this->getVector() as $movement)
		{
			$result[] = $movement->getFromIndex()." ".$this->getHitIndex($movement).$movement->getToIndex();
		}
		return implode("x", $result ?? []);
	}

	private function getHitIndex(Movement $movement): string
	{
		return ($movement->hasHitIndex()) ? $movement->getHitIndex()." " : "";
	}
}
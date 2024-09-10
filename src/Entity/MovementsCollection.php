<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Trait\Collection\VectorPropertiesElement;

class MovementsCollection implements \Iterator
{
	use VectorPropertiesElement;

	public function merge(MovementsCollection $movementsCollection): object
	{
		if($movementsCollection->hasVector())
		{
			$this->mergeArray($movementsCollection->getVector());
		}
		return $this;
	}

	public function getArray(): array
	{
		foreach($this->vector ?? [] as $movementCollection)
		{
			$result[] = $this->getResult($movementCollection);
		}
		return $result ?? [];
	}

	public function display(): void
	{
		echo $this->getNumeratedString();
	}

	private function getString(): string
	{
		return implode(PHP_EOL, $this->getStringArray());
	}

	private function getStringArray(): array
	{
		foreach($this->getArray() as $movement)
		{
			$result[] = $this->getPart($movement);
		}
		return $result ?? [];
	}

	private function getNumeratedString(): string
	{
		foreach($this->getStringArray() as $key => $movement)
		{
			$result[] = ($key+1).". ".$movement;
		}
		return implode(PHP_EOL, $result ?? []);
	}

	private function getPart(array $movement): string
	{
		foreach($movement as $iterator => $turn)
		{
			$turns = isset($turns) ? $turns.$this->getChunk($iterator, $turn) : $this->getChunk($iterator, $turn);
		}
		return $turns ?? "";
	}

	private function getChunk(int $iterator, array $turn): string
	{
		return ($turn["hitIndex"] !== "") ? $this->getJumpsString($iterator, $turn) : $this->getStepString($turn);
	}

	private function getJumpsString(int $iterator, array $turn): string
	{
		if($iterator == 0)
		{
			return $turn["fromIndex"]."x".$turn["hitIndex"]."x".$turn["toIndex"];
		}
		return "x".$turn["hitIndex"]."x".$turn["toIndex"];
	}

	private function getStepString(array $turn): string
	{
		return $turn["fromIndex"]."-".$turn["toIndex"];
	}

	private function getResult(MovementCollection $movementCollection): array
	{
		foreach($movementCollection as $key => $movement)
		{
			$result[$key] = $this->getElement($movement);
		}
		return $result ?? [];
	}

	private function getElement(Movement $movement): array
	{
		return [
			"fromIndex" => $movement->getFromIndex(),
			"hitIndex" => $movement->hasHitIndex() ? $movement->getHitIndex() : "",
			"toIndex" => $movement->getToIndex()
		];
	}
}
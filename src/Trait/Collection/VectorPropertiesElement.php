<?php

namespace Arknet\LineReracer\Trait\Collection;

trait VectorPropertiesElement
{
	private int $iterator;
	private array $vector;

	public function getBetween(int $offset1, int $offset2): array
	{
		return array_slice($this->vector, $offset1, $offset2);
	}

	public function mergeArray(array $array): void
	{
		if(!$this->hasVector())
		{
			$this->vector = [];
		}
		$this->vector = array_values(array_merge($this->vector, $array));
	}

	public function rewind(): void
	{
		$this->iterator = 0;
	}

	#[\ReturnTypeWillChange]
	public function key(): int
	{
		return $this->iterator;	
	}

	#[\ReturnTypeWillChange]
	public function current(): object
	{
		return $this->vector[$this->iterator];
	}

	public function next(): void
	{
		++$this->iterator;
	}

	public function valid(): bool
	{
		return isset($this->vector[$this->iterator]);
	}

	public function getVector(): array
	{
		return $this->vector;
	}

	public function hasVector(): bool
	{
		return isset($this->vector);
	}

	public function setVector(array $vector): object
	{
		$this->vector = $vector;
		return $this;
	}

	public function add(object $object): object
	{
		$this->vector[] = $object;
		return $this;
	}

	public function countVector(): int
	{
		return $this->hasVector() ? count($this->vector) : 0;
	}

	public function isEmpty(): bool
	{
		return $this->countVector() === 0;
	}
	
	public function getEnd(): object
	{
		return $this->vector[count($this->vector) - 1];
	}
}
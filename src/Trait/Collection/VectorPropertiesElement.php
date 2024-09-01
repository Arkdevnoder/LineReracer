<?php

namespace Arknet\LineReracer\Trait\Collection;

trait VectorPropertiesElement
{
	private int $iterator;
	private array $vector;

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
}
<?php

namespace Arknet\LineReracer\Entity;

class PositionCollection
{
	public const RowsLength = 8;
	public const ColumnsLength = 8;

	private array $rows;

	public function __construct()
	{

	}

	public function getRows(): array
	{
		return $this->rows;
	}

	private function initializeRows(): array
	{
		for($i = 0; $i < static::RowsLength; $i++)
		{
			
		}
	}
}
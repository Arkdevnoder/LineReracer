<?php

namespace Arknet\LineReracer\Trait\Service;

trait Catalog
{
	private array $services = [
		"board" => \Arknet\LineReracer\Definition\Board::class,
		"engine" => \Arknet\LineReracer\Definition\Engine::class
	];

	public function getServices(): array
	{
		return $this->services;
	}
}
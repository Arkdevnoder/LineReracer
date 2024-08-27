<?php

namespace Arknet\LineReracer\Trait\Service;

trait Catalog
{
	private array $services = [
		"board" => [
			"name" => \Arknet\LineReracer\Definition\Board::class
		],
		"engine" => [
			"name" => \Arknet\LineReracer\Definition\Engine::class
		],
		"displayer" => [
			"name" => \Arknet\LineReracer\Definition\Displayer::class
		],
	];

	public function getServices(): array
	{
		return $this->services;
	}
}
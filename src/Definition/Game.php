<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Definition\Board;
use Arknet\LineReracer\Definition\Engine;
use Arknet\LineReracer\Definition\Displayer;
use Arknet\LineReracer\Trait\Service\Catalog;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Arknet\LineReracer\Contracts\Registrator\Container\Merger;

class Game implements Merger
{
	use Catalog;

	private ContainerBuilder $container;

	public function __construct()
	{
		$this->initServiceContainer();
	}

	public function initServiceContainer(): void
	{
		$this->container = new ContainerBuilder();
		$this->defineServiceContainer();
	}

	public function defineServiceContainer(): void
	{
		foreach($this->getServices() as $key => $service)
		{
			$this->getContainer()->register($key, $service["name"]);
		}
	}

	public function getBoard(): Board
	{
		return $this->getContainer()->get("board");
	}

	public function getEngine(): Engine
	{
		return $this->getContainer()->get("engine");
	}

	public function getDisplayer(): Displayer
	{
		return $this->getContainer()->get("displayer");
	}

	protected function getContainer(): ContainerBuilder
	{
		return $this->container;
	}
}
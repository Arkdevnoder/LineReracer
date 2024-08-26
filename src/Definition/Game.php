<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Trait\Service\Catalog;
use Arknet\LineReracer\Registrator\Container\Merger;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Game implements Merger
{
	use Catalog;

	private ContainerBuilder $containter;

	public function __construct()
	{
		$this->container = new ContainerBuilder();
	}

	public function defineServiceContainer(): void
	{
		foreach($this->getServices() as $key => $service)
		{
			$this->getContainer()->register($key, $service);
		}
	}

	private function getContainer(): array
	{
		return $this->container;
	}
}
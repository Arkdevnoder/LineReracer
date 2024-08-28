<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Definition\Board;
use Symfony\Component\Config\FileLocator;
use Arknet\LineReracer\Definition\Engine;
use Arknet\LineReracer\Definition\Displayer;
use Arknet\LineReracer\Trait\Registrator\Catalog;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Arknet\LineReracer\Contracts\Registrator\Container\Merger;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

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
		$this->configureAutowire();
	}

	public function configureAutowire(): void
	{
		$this->getLoader()->load('Config/Autowire.php');
		$this->getContainer()->compile();
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

	private function getLoader(): PhpFileLoader
	{
		return new PhpFileLoader(
			$this->getContainer(),
			new FileLocator(__DIR__."/../")
		);
	}
}
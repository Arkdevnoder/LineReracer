<?php

namespace Arknet\LineReracer\Trait\Registrator;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

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
		]
	];

	private string $excludeAutowire = '../src/{Config/Autowire.php,Contracts/*}';

	public function getServices(): array
	{
		return $this->services;
	}

	public function setup(ContainerConfigurator $container): void
	{
		$container->services()->load('Arknet\\LineReracer\\', '../src/')
			  ->exclude($this->excludeAutowire);

		foreach($this->getServices() as $key => $service)
		{
			$container->services()->set($key, $service["name"])->autowire()->public();
		}
	}
}
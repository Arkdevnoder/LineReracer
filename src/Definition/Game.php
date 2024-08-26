<?php

namespace Arknet\LineReracer\Definition;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class Game
{
	private function $containter;

	public function __constuctor()
	{
		$this->container = new ContainerBuilder();
	}
}
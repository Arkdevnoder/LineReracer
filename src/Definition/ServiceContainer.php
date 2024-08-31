<?php

namespace Arknet\LineReracer\Definition;

use Psr\Container\ContainerInterface;

class ServiceContainer implements ContainerInterface
{
	private array $services;

	public function __construct()
	{
		$this->services = (array) null;
	}

	public function set(string $key, object $object): object
	{
		$this->services[$key] = $object;
		return $this;
	}

	public function get(string $key): object
	{
		return $this->services[$key];
	}

	public function has(string $key): bool
	{
		return isset($this->services[$key]);
	}
}
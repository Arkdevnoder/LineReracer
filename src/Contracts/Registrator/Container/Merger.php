<?php

namespace Arknet\LineReracer\Contracts\Registrator\Container;

interface Merger
{
	public function configureAutowire(): void;
}
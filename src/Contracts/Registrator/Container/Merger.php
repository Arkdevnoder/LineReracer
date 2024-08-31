<?php

namespace Arknet\LineReracer\Contracts\Registrator\Container;

use Arknet\LineReracer\Definition\Board;
use Arknet\LineReracer\Definition\Engine;
use Arknet\LineReracer\Definition\Displayer;

interface Merger
{
	public function getBoard(): Board;

	public function getEngine(): Engine;

	public function getDisplayer(): Displayer;
}
<?php

namespace Arknet\LineReracer\Contracts\Board;

interface Action {
	public function getPossibleMoves();
}
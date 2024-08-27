<?php

namespace Arknet\LineReracer\Board;

interface Action {
	public function getPossibleMoves();
}
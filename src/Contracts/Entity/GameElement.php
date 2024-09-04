<?php

namespace Arknet\LineReracer\Contracts\Entity;

interface GameElement {
	public function get(): string;
	public function getValue(): string;
}
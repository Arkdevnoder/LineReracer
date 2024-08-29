<?php

namespace Arknet\LineReracer\Entity;

use Arknet\LineReracer\Contracts\Entity\GameElement;

class Emptiness implements GameElement
{
    public function __get(string $name): string
    {
        return (string) null;
    }

    public function get(): string
    {
        return static::DefaultValue;
    }
}
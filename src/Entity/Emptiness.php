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
        return $this->defaultValue;
    }

    public function getValue(): string
    {
        return $this->defaultValue;
    }

    public function isEnemy(): bool
    {
        return false;
    }

    public function isAlly(): bool
    {
        return false;
    }
}
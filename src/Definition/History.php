<?php

namespace Arknet\LineReracer\Definition;

class History
{
    private array $list;

    public function setList(array $list): object
    {
        $this->list = $list;
        return $this;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function addToList(string $notation): object
    {
        $this->list[] = $notation;
        return $this;
    }

    public function getNotation(): string
    {
        return implode(":", $this->list);
    }

    public function setNotation(string $notation): object
    {
        $this->list = explode(":", $notation);
        return $this;
    }
}
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

    public function isDraw(): bool
    {
        if(!empty($this->list) && count($this->list) > 11)
        {
            return $this->isDrawContinue();
        }
        return false;
    }

    public function isDrawContinue(): bool
    {
        $index = count($this->list) - 1;
        $condition1 = $this->list[$index];
        $condition2 = $this->list[$index-4];
        $condition3 = $this->list[$index - 8];
        return $condition1 == ($condition2 == $condition3);
    }

}
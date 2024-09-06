<?php

namespace Arknet\LineReracer\Entity;

class Movement
{
	private int $fromIndex;
    private int $hitIndex;
    private int $toIndex;

    public function setFromIndex(int $fromIndex): object
    {
        $this->fromIndex = $fromIndex;
        return $this;
    }

    public function setHitIndex(int $hitIndex): object
    {
        $this->hitIndex = $hitIndex;
        return $this;
    }

    public function setToIndex(int $toIndex): object
    {
        $this->toIndex = $toIndex;
        return $this;
    }

    public function getFromIndex(): int
    {
        return $this->fromIndex;
    }

    public function getHitIndex(): int
    {
        return $this->hitIndex;
    }

    public function getToIndex(): int
    {
        return $this->toIndex;
    }

    public function hasHitIndex(): int
    {
        return isset($this->hitIndex);
    }
}
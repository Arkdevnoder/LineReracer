<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Game;

trait Indexesable
{
    private array $indexes;

    public function setIndexes(array $indexes): object
    {
        $this->indexes = $indexes;
        return $this;
    }

    public function getIndexes(): int
    {
        return $this->indexes;
    }
}
<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Entity\PositionCollection;

trait PositionCollectionable
{
    private PositionCollection $positionCollection;

    public function setPositionCollection(PositionCollection $positionCollection): object
    {
        $this->positionCollection = $positionCollection;
        return $this;
    }

    public function getPositionCollection(): PositionCollection
    {
        return $this->positionCollection;
    }
}
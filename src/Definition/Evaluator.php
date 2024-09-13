<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Entity\Emptiness;
use Arknet\LineReracer\Trait\Initor\Gameable;
use Arknet\LineReracer\Contracts\Entity\GameElement;

class Evaluator
{
    use Gameable;

    private int $ratio;

    private int $result;

    public function __construct()
    {
        $this->result = 0;
    }

    public function getRatio(): int
    {
        $this->result = 0;
        return $this->getRatioContinue();
    }

    private function getRatioContinue(): int
    {
        foreach($this->getGame()->getBoard()->getPositionCollection() as $gameElement)
        {
            $this->setResultBasedOnGameElement($gameElement);
        }
        return $this->result;
    }

    private function setResultBasedOnGameElement(GameElement $gameElement): void
    {
        $this->result += ($gameElement instanceof Emptiness) ? 0
        : ($gameElement->isWhite() ? 1000 : -1000)*($gameElement->isQueen() ? 4 : 1);
    }
}
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

    private array $masks;

    private array $benefitsMask = [
        0, 0, 0, 0,
        500, 400, 400, 500,
        400, 300, 300, 300,
        200, 200, 200, 200,
        100, 200, 200, 100,
        0, 0, 0, 0,
        0, 0, 0, 0,
        0, 0, 2000, 0
    ];

    public function __construct()
    {
        $this->result = 0;
    }

    public function getMask(bool $isWhite): array
    {
        return $isWhite ? $this->benefitsMask : $this->getBlackBenefitsMask();
    }

    public function getRatio(): int
    {
        $this->result = 0;
        return $this->getRatioContinue();
    }

    private function getBlackBenefitsMask(): array
    {
        foreach(array_reverse($this->benefitsMask) as $element)
        {
            $result[] = $element*-1;
        }
        return $result;
    }

    private function getRatioContinue(): int
    {
        foreach($this->getGame()->getBoard()->getPositionCollection() as $key => $gameElement)
        {
            $this->setResultBasedOnGameElement($key, $gameElement);
        }
        return $this->result;
    }

    private function setResultBasedOnGameElement(int $key, GameElement $gameElement): void
    {
        $masks = $this->setMasks();
        $benefit = ($gameElement instanceof Emptiness) ? 0 : $this->getBenefit($key, $gameElement);
        $this->result += ($gameElement instanceof Emptiness) ? 0
        : ($gameElement->isWhite() ? 1000 : -1000)*($gameElement->isQueen() ? 4 : 1)+$benefit;
    }

    private function getBenefit(int $key, GameElement $gameElement): int
    {
        if($gameElement->isQueen())
        {
            return 0;
        }
        return $gameElement->isWhite() ? $this->masks["white"][$key] : $this->masks["black"][$key];
    }

    private function setMasks(): void
    {
        $this->masks = $this->getMasks();
    }

    private function getMasks(): array
    {
        return [
            "white" => $this->getMask(true),
            "black" => $this->getMask(false)
        ];
    }
}
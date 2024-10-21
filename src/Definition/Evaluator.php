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

    private int $whiteLeftSided = 0;
    private int $whiteRightSided = 0;

    private int $blackLeftSided = 0;
    private int $blackRightSided = 0;

    private array $benefitsMask = [
        0, 0, 0, 0,
        50, 40, 40, 50,
        40, 30, 30, 30,
        20, 20, 20, 20,
        10, 20, 20, 10,
        0, 0, 0, 0,
        -10, -10, -10, -10,
        -20, -20, 1000, -20
    ];

    private array $leftSide = [
        0, 1, 4, 5, 8, 9, 12, 13, 16, 17, 20, 21, 24, 25, 28, 29
    ];

    public function __construct()
    {
        $this->flush();
    }

    public function getMask(bool $isWhite): array
    {
        return $isWhite ? $this->benefitsMask : $this->getBlackBenefitsMask();
    }

    public function getRatio(): int
    {
        $this->flush();
        $ratio = $this->getRatioContinue();
        return $ratio + $this->getSideRatio();
    }

    private function getSideRatio(): int
    {
        $diffWhite = -abs($this->whiteLeftSided - $this->whiteRightSided);
        $diffBlack = abs($this->blackLeftSided - $this->blackRightSided);
        return ($diffWhite+$diffBlack)*100;
    }

    private function flush(): void
    {
        $this->result = 0;
        $this->whiteLeftSided = 0;
        $this->whiteRightSided = 0;
        $this->blackLeftSided = 0;
        $this->blackRightSided = 0;
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
        $gameElement instanceof Emptiness ?: $this->recountSides($key, $gameElement);
        $masks = $this->setMasks();
        $benefit = ($gameElement instanceof Emptiness) ? 0 : $this->getBenefit($key, $gameElement);
        $this->result += ($gameElement instanceof Emptiness) ? 0
        : ($gameElement->isWhite() ? 1000 : -1000)*($gameElement->isQueen() ? 4 : 1)+$benefit;
    }

    private function recountSides(int $key, GameElement $gameElement): void
    {
        $gameElement->isWhite() ? $this->recountWhiteSides($key) : $this->recountBlackSides($key);
    }

    private function recountWhiteSides(int $key): void
    {
        $check = in_array($key, $this->leftSide);
        $this->whiteLeftSided = !$check ? $this->whiteLeftSided : $this->whiteLeftSided + 1;
        $this->whiteRightSided = $check ? $this->whiteRightSided : $this->whiteRightSided + 1;
    }

    private function recountBlackSides(int $key): void
    {
        $check = in_array($key, $this->leftSide);
        $this->blackLeftSided = !$check ? $this->blackLeftSided : $this->blackLeftSided + 1;
        $this->blackRightSided = $check ? $this->blackRightSided : $this->blackRightSided + 1;
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
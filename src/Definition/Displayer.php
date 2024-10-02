<?php

namespace Arknet\LineReracer\Definition;

use Arknet\LineReracer\Trait\Initor\Turnable;
use Arknet\LineReracer\Trait\Initor\Evaluatorable;
use Arknet\LineReracer\Trait\Initor\PositionCollectionable;

class Displayer
{
    use Turnable, PositionCollectionable, Evaluatorable;

	public function out(): void
    {
        $this->outHeaderLine();
        $this->outContent();
        $this->outFooterLine();
    }

    private function outHeaderLine(): void
    {
        echo "Score: ".$this->getEvaluator()->getRatio()
        .", noBeatsMoves: ".$this->getTurn()->getNoBeatsMoves().PHP_EOL;
        echo "==========================".PHP_EOL;
    }

    private function outFooterLine(): void
    {
        echo "==========================".PHP_EOL;
    }

    private function outContent(): void
    {
        for($key = 0; $key < $this->getPositionCollection()->getRowsLength(); $key++)
        {
            $this->outRow($key);
        }
    }

    public function outRow(int $row): void
    {
        for($key = 0; $key < $this->getPositionCollection()->getColumnsLength(); $key++)
        {
            echo $this->getField($key, $row);
        }
        echo " !".PHP_EOL;
    }

    public function getField(int $x, int $y): string
    {
        if($this->getPositionCollection()->hasIndexByCoordinates($x, $y)){
            return $this->getValue($x, $y);
        }
        return "   ";
    }

    private function getValue(int $x, int $y): string
    {
        $index = $this->getTwoDigits($this->getPositionCollection()->getIndexByCoordinates($x, $y));
        $value = $this->getPositionCollection()->getElementByCoordinates($x, $y)->getValue();
        $emptiness = "_".str_replace($this->getUpperDigits(), $this->getLowerDigits(), $index);
        return ($value == "") ? $emptiness : $value.$index;
    }

    private function getUpperDigits(): array
    {
        return ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    }

    private function getLowerDigits(): array
    {
        return ["₀", "₁", "₂", "₃", "₄", "₅", "₆", "₇", "₈", "₉"];
    }

    private function getTwoDigits(int $int): string
    {
        if($int < 10)
        {
            return "0".$int;
        }
        return $int;
    }

}
<?php

namespace Arknet\LineReracer\Trait\Initor;

use Arknet\LineReracer\Definition\Evaluator;

trait Evaluatorable
{
    private Evaluator $evaluator;

    public function setEvaluator(Evaluator $evaluator): object
    {
        $this->evaluator = $evaluator;
        return $this;
    }

    public function getEvaluator(): Evaluator
    {
        return $this->evaluator;
    }
}
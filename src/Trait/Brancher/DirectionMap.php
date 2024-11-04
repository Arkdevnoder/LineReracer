<?php

namespace Arknet\LineReracer\Trait\Brancher;

trait DirectionMap
{
    public string $directionNE = "NE";
    public string $directionSE = "SE";
    public string $directionSW = "SW";
    public string $directionNW = "NW";

    public array $map = [
        "SE" => [
            "x" => 1,
            "y" => 1
        ],
        "NE" => [
            "x" => 1,
            "y" => -1
        ],
        "NW" => [
            "x" => -1,
            "y" => -1
        ],
        "SW" => [
            "x" => -1,
            "y" => 1
        ]
    ];

    public function getOffset(string $direction): array
    {
        $coordinates = $this->map[$direction];
        return $coordinates;
    }

    public function multiplyOffset(array $offset, int $ratio): array
    {
        return [
            "x" => $offset["x"]*$ratio,
            "y" => $offset["y"]*$ratio
        ];
    }
}
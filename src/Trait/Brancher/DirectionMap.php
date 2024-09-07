<?php

namespace Arknet\LineReracer\Trait\Brancher;

trait DirectionMap
{
    public const DirectionNE = "NE";
    public const DirectionSE = "SE";
    public const DirectionSW = "SW";
    public const DirectionNW = "NW";

    public const Map = [
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
        $coordinates = static::Map[$direction];
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
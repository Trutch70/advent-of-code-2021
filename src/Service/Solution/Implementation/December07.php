<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;

class December07 implements SolutionInterface
{
    public function getDayNumber(): string
    {
        return '7';
    }

    public function prepareInput($input): array
    {
        return array_map(function (string $char) {
            return (int)$char;
        }, explode(',', trim($input)));
    }

    public function getFirstPartSolution($input): string
    {
        $lowest = null;
        for ($i = min($input); $i <= max($input); $i++) {
            $totalFuel = 0;
            foreach ($input as $coordinate) {
                $totalFuel += abs($coordinate - $i);
            }
            if (!$lowest || $totalFuel < $lowest) {
                $lowest = $totalFuel;
            }
        }
        return (string)$lowest;
    }

    public function getSecondPartSolution($input): string
    {
        $lowest = null;
        $bestCoordinate = null;

        for ($i = min($input); $i <= max($input); $i++) {
            $totalFuel = 0;
            foreach ($input as $coordinate) {
                $distance = abs($coordinate - $i);
                $totalFuel += ($distance) * ($distance + 1) /2;
            }

            if (is_null($lowest) || $totalFuel < $lowest) {
                $lowest = $totalFuel;
                $bestCoordinate = $i;
            }
        }
        var_dump($bestCoordinate);
        return (string)$lowest;
    }
}

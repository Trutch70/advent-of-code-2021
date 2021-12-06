<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;

class December05 implements SolutionInterface
{
    public function getDayNumber(): string
    {
        return '5';
    }

    public function prepareInput($input): array
    {
        $array = explode(PHP_EOL, trim($input));

        return array_map(function ($line) {
            preg_match('/^([0-9]+),\s?([0-9]+)\s->\s([0-9]+),\s?([0-9]+)$/', trim($line), $matches);
            return [
                'from' => [
                    'x' => $matches[1],
                    'y' => $matches[2],
                ],
                'to' => [
                    'x' => $matches[3],
                    'y' => $matches[4],
                ]
            ];
        }, $array);
    }

    public function getFirstPartSolution($input): string
    {
        $savedCoordinates = [];

        $overlapCount = 0;

        foreach ($input as $coordinates) {
            $overlapCount = $this->modifyOverlapCount($savedCoordinates, $coordinates, $overlapCount, false);
        }

        return (string)$overlapCount;
    }

    public function getSecondPartSolution($input): string
    {
        $savedCoordinates = [];

        $overlapCount = 0;

        foreach ($input as $coordinates) {
            $overlapCount = $this->modifyOverlapCount($savedCoordinates, $coordinates, $overlapCount);
        }

        return (string)$overlapCount;
    }

    private function modifyOverlapCount(array &$savedCoordinates, $coordinates, $overlapCount, bool $diagonal = true): int
    {
        $coordinates['all'] = [];
        $xDiff = $coordinates['to']['x'] - $coordinates['from']['x'];
        $yDiff = $coordinates['to']['y'] - $coordinates['from']['y'];

        if (!$diagonal && $xDiff !== 0 && $yDiff !== 0) {
            return $overlapCount;
        }

        $finished = false;
        if ($xDiff > 0) {
            $xMultiplier = -1;
        } else {
            $xDiff = -1 * $xDiff;
            $xMultiplier = 1;
        }

        if ($yDiff > 0) {
            $yMultiplier = -1;
        } else {
            $yDiff = $yDiff * -1;
            $yMultiplier = 1;
        }
        while (!$finished) {

            $coordinates['all'][] = [
                'x' => $coordinates['to']['x'] + ($xDiff * $xMultiplier),
                'y' => $coordinates['to']['y'] + ($yDiff * $yMultiplier),
            ];


            if ($xDiff == 0 && $yDiff == 0) {
                $finished = true;
            }

            if ($xDiff != 0) {
                $xDiff--;
            }

            if ($yDiff != 0) {
                $yDiff--;
            }
        }
        foreach ($coordinates['all'] as $coordinate) {
            if (!isset($savedCoordinates[$coordinate['x']])) {
                $savedCoordinates[$coordinate['x']] = [];
            }

            if (!isset($savedCoordinates[$coordinate['x']][$coordinate['y']])) {
                $savedCoordinates[$coordinate['x']][$coordinate['y']] = 0;
            }

            $savedCoordinates[$coordinate['x']][$coordinate['y']]++;

            if ($savedCoordinates[$coordinate['x']][$coordinate['y']] === 2) {
                $overlapCount++;
            }
        }

        return $overlapCount;
    }
}

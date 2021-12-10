<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;

class December09 implements SolutionInterface
{
    public function getDayNumber(): string
    {
        return '9';
    }

    public function prepareInput($input): array
    {
        return array_values(array_map(function (string $line) {
            return array_values(str_split($line));
        }, explode(PHP_EOL, trim($input))));
    }

    public function getFirstPartSolution($input): string
    {
        $sum = 0;

        foreach ($input as $y => $xs) {
            foreach ($xs as $x => $value) {
                if ($this->pointLowest($input, $x, $y)) {
                    $sum += ((int)$value + 1);
                }
            }
        }

        return (string)$sum;
    }

    public function getSecondPartSolution($input): string
    {
        $lowest = [];

        foreach ($input as $y => $xs) {
            foreach ($xs as $x => $value) {
                if ($this->pointLowest($input, $x, $y)) {
                    $lowest[] = [
                        'x' => $x,
                        'y' => $y,
                        'value' => $value,
                    ];
                }
            }
        }

        $basins = [];

        foreach ($lowest as $key => $lowestPoint) {
            $basins[$key] = $this->getBasin([], $input, $lowestPoint['x'], $lowestPoint['y']);
        }

        $basinsSizes = array_map(function (array $basin) {
            return count($basin);
        }, $basins);

        $maxSizes = [];
        for ($i = 0; $i < 3; $i++) {
            $maxSizes[] = max($basinsSizes);
            unset($basinsSizes[array_search(max($basinsSizes), $basinsSizes)]);
        }

        $result = 1;

        foreach ($maxSizes as $maxSize) {
            $result *= $maxSize;
        }
        return (string)$result;
    }

    private function pointLowest(array $input, int $x, int $y): bool
    {
        foreach ($this->getAdjacentPoints($input, $x, $y) as $point) {
            if ((int)$input[$y][$x] >= $point['value']) {
                return false;
            }
        }

        return true;
    }

    private function getAdjacentPoints(array $input, int $x, int $y): array
    {
        $adjacent = [];

        if (isset($input[$y - 1][$x])) {
            $adjacent[] = [
                'x' => $x,
                'y' => $y - 1,
                'value' => $input[$y -1][$x]
            ];
        }

        if (isset($input[$y][$x - 1])) {
            $adjacent[] = [
                'x' => $x - 1,
                'y' => $y,
                'value' => $input[$y][$x - 1]
            ];
        }

        if (isset($input[$y][$x + 1])) {
            $adjacent[] = [
                'x' => $x + 1,
                'y' => $y,
                'value' => $input[$y][$x + 1]
            ];
        }

        if (isset($input[$y + 1][$x])) {
            $adjacent[] = [
                'x' => $x,
                'y' => $y + 1,
                'value' => $input[$y + 1][$x]
            ];
        }

        return $adjacent;
    }

    private function getBasin(array $basin, array $input, $x, $y): array
    {
        if (in_array(['x' => $x, 'y' => $y, 'value' => $input[$y][$x]], $basin)) {
            return $basin;
        }

        $basin[] = [
            'x' => $x,
            'y' => $y,
            'value' => $input[$y][$x]
        ];

        $adjacent = $this->getAdjacentPoints($input, $x, $y);

        foreach ($adjacent as $point) {
            if ($point['value'] == 9) {
                continue;
            }
            $basin = $this->getBasin($basin, $input, $point['x'], $point['y']);
        }

        return $basin;
    }
}

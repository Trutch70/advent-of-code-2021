<?php

declare(strict_types=1);

namespace App\Service\Solution;

class December01 extends AbstractSolution
{
    public function getDayNumber(): string
    {
        return '1';
    }

    public function prepareInput($input): array
    {
        return explode(PHP_EOL, $input);
    }

    public function getFirstPartSolution($input): string
    {
        $count = 0;

        foreach ($input as $key => $measurement) {
            if (isset($input[$key + 1]) && $input[$key + 1] > $measurement) {
                $count++;
            }
        }

        return (string)$count;
    }

    public function getSecondPartSolution($input): string
    {
        $groupedMeasurements = [];
        $groupedCount = 0;

        foreach ($input as $key => $measurement) {
            if (isset($input[$key + 1]) && isset($input[$key + 2])) {
                $groupedMeasurements[] = (int)$measurement + (int)$input[$key + 1] + (int)$input[$key + 2];
            }
        }

        foreach ($groupedMeasurements as $key => $groupedMeasurement) {
            if (
                $groupedMeasurement &&
                isset($groupedMeasurements[$key + 1]) &&
                $groupedMeasurement < $groupedMeasurements[$key + 1]
            ) {
                $groupedCount++;
            }
        }

        return (string)$groupedCount;
    }
}

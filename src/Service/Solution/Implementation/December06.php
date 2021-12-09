<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;

class December06 implements SolutionInterface
{
    public function getDayNumber(): string
    {
        return '6';
    }

    public function prepareInput($input): array
    {
        return array_map(function (string $char) {
            return (int)$char;
        }, explode(',', trim($input)));
    }

    public function getFirstPartSolution($input): string
    {
        for ($i = 0; $i < 80; $i++) {
            foreach ($input as $key => $counter) {
                $input[$key]--;
                if ($input[$key] < 0 ) {
                    $input[] = 8;
                    $input[$key] = 6;
                }
            }
        }

        return (string)count($input);
    }

    public function getSecondPartSolution($input): string
    {
        $sortedCounters = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
        ];

        foreach ($input as $counter) {
            $sortedCounters[$counter]++;
        }

        for ($i = 0; $i < 256; $i++) {
            $modifiedCounters = [
                0 => $sortedCounters[1],
                1 => $sortedCounters[2],
                2 => $sortedCounters[3],
                3 => $sortedCounters[4],
                4 => $sortedCounters[5],
                5 => $sortedCounters[6],
                6 => $sortedCounters[7] + $sortedCounters[0],
                7 => $sortedCounters[8],
                8 => $sortedCounters[0],
            ];

            $sortedCounters = $modifiedCounters;
        }

        $count = 0;

        foreach ($sortedCounters as $counter) {
            $count+= $counter;
        }

        return (string)$count;
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\AbstractSolution;

class December03 extends AbstractSolution
{
    public function getDayNumber(): string
    {
        return '3';
    }

    public function prepareInput($input)
    {
        return explode(PHP_EOL, trim($input));
    }

    public function getFirstPartSolution($input): string
    {
        $count = count($input);
        $counts = [
        ];

        foreach ($input as $row) {
            foreach (str_split($row) as $key => $letter) {
                if ($letter === '1') {
                    if (!isset($counts[$key])) {
                        $counts[$key] = 0;
                    }
                    $counts[$key] += 1;
                }
            }
        }

        $binaryGamma = $this->getBitsForMostCommonBits($counts, $count);
        $binaryEpsilon = $this->getOppositeBinaryNumber($binaryGamma);

        $gamma = bindec($binaryGamma);

        $epsilon = bindec($binaryEpsilon);

        return (string)($gamma * $epsilon);
    }

    public function getSecondPartSolution($input): string
    {
       $oxygenFound = false;
       $co2Found = false;

       $oxygenInputs = $input;
       $co2Inputs = $input;

        $i = 0;
        while (!$oxygenFound) {
           $count = 0;
           foreach ($oxygenInputs as $oxygenInputRow) {
               if (!isset($oxygenInputRow[$i])) {
                   $i = 0;
               }

               if ($oxygenInputRow[$i] == '1') {
                   $count++;
               }
           }

           $mostCommon = $this->getBitForMostCommonBit($count, count($oxygenInputs));

           foreach ($oxygenInputs as $key => $oxygenInput) {
               if ((string)$mostCommon !== $oxygenInput[$i]) {
                   unset($oxygenInputs[$key]);
               }
           }

           if (1 === count($oxygenInputs)) {
                $oxygenFound = $oxygenInputs[array_key_first($oxygenInputs)];
           }

           $i++;
       }

        $i = 0;
        while (!$co2Found) {
           $count = 0;
           foreach ($co2Inputs as $co2InputRow) {
               if (!isset($co2InputRow[$i])) {
                   $i = 0;
               }

               if ($co2InputRow[$i] == '1') {
                   $count++;
               }
           }

           $leastCommon = $this->getBitForLeastCommonBit($count, count($co2Inputs));

           foreach ($co2Inputs as $key => $co2Input) {
               if ((string)$leastCommon !== $co2Input[$i]) {
                   unset($co2Inputs[$key]);
               }
           }

           if (1 === count($co2Inputs)) {
                $co2Found = $co2Inputs[array_key_first($co2Inputs)];
           }

           $i++;
       }

       return (string)(bindec($oxygenFound) * bindec($co2Found));
    }

    private function getBitForMostCommonBit(int $count, int $totalCount): int
    {
        return $count >= $totalCount/2 ? 1 : 0;
    }

    private function getBitForLeastCommonBit(int $count, int $totalCount): int
    {
        return $count < $totalCount/2 ? 1 : 0;
    }

    private function getBitsForMostCommonBits(array $counts, int $totalCount): string
    {
        ksort($counts);

        $newString = '';

        foreach ($counts as $count) {
            $newString .= $this->getBitForMostCommonBit($count, $totalCount);
        }

        return $newString;
    }

    private function getOppositeBinaryNumber(string $gammaBits): string
    {
        $newString = '';

        foreach (str_split($gammaBits) as $char) {
            $newString .= $char === '1' ? '0' : '1';
        }

        return $newString;
    }
}

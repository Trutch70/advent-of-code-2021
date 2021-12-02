<?php

declare(strict_types=1);

namespace App\Service\Solution;

class December02 extends AbstractSolution
{
    public function getDayNumber(): string
    {
        return '2';
    }

    public function prepareInput($input): array
    {
        $stringCommands = explode(PHP_EOL, trim($input));

        return array_map(function (string $stringCommand) {
            preg_match_all('/(forward|up|down)\s([0-9]+)/', $stringCommand, $matches);
            return [
                'command' => $matches[1][0],
                'value' => (int)$matches[2][0],
            ];
        }, $stringCommands);
    }

    public function getFirstPartSolution($input): string
    {
        $xPos = 0;
        $yPos = 0;

        foreach ($input as $commandValue) {
            switch ($commandValue['command']) {
                case 'forward':
                    $xPos += (int)$commandValue['value'];
                    break;
                case 'up':
                    $yPos -= (int)$commandValue['value'];
                    break;
                case 'down':
                    $yPos += (int)$commandValue['value'];
                    break;
                default:
                    break;
            }
        }

        return (string)($xPos * $yPos);
    }

    public function getSecondPartSolution($input): string
    {
        $xPos = 0;
        $yPos = 0;
        $aim = 0;

        foreach ($input as $commandValue) {
            switch ($commandValue['command']) {
                case 'forward':
                    $xPos += (int)$commandValue['value'];
                    $yPos += (int)$commandValue['value'] * $aim;
                    break;
                case 'up':
                    $aim -= (int)$commandValue['value'];
                    break;
                case 'down':
                    $aim += (int)$commandValue['value'];
                    break;
                default:
                    break;
            }
        }

        return (string)($xPos * $yPos);
    }
}

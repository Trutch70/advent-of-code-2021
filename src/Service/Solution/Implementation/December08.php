<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;

class December08 implements SolutionInterface
{
    const TOP = 'a';
    const TOP_LEFT = 'b';
    const TOP_RIGHT = 'c';
    const MIDDLE = 'd';
    const BOTTOM_LEFT = 'e';
    const BOTTOM_RIGHT = 'f';
    const BOTTOM = 'g';

    const POSITIONS = [
        self::TOP,
        self::TOP_LEFT,
        self::TOP_RIGHT,
        self::MIDDLE,
        self::BOTTOM_LEFT,
        self::BOTTOM_RIGHT,
        self::BOTTOM,
    ];

    const ZERO = [
        'map' => [
            self::TOP,
            self::TOP_LEFT,
            self::TOP_RIGHT,
            self::BOTTOM_LEFT,
            self::BOTTOM_RIGHT,
            self::BOTTOM,
        ],
        'value' => 0,
    ];
    const ONE = [
        'map' => [
            self::TOP_RIGHT,
            self::BOTTOM_RIGHT,
        ],
        'value' => 1,
    ];
    const TWO = [
        'map' => [
            self::TOP,
            self::TOP_RIGHT,
            self::MIDDLE,
            self::BOTTOM_LEFT,
            self::BOTTOM,
        ],
        'value' => 2,
    ];
    const THREE = [
        'map' => [
            self::TOP,
            self::TOP_RIGHT,
            self::MIDDLE,
            self::BOTTOM_RIGHT,
            self::BOTTOM,
        ],
        'value' => 3,
    ];
    const FOUR = [
        'map' => [
            self::TOP_LEFT,
            self::TOP_RIGHT,
            self::MIDDLE,
            self::BOTTOM_RIGHT,
        ],
        'value' => 4,
    ];
    const FIVE = [
        'map' => [
            self::TOP,
            self::TOP_LEFT,
            self::MIDDLE,
            self::BOTTOM_RIGHT,
            self::BOTTOM,
        ],
        'value' => 5,
    ];
    const SIX = [
        'map' => [
            self::TOP,
            self::TOP_LEFT,
            self::MIDDLE,
            self::BOTTOM_LEFT,
            self::BOTTOM_RIGHT,
            self::BOTTOM,
        ],
        'value' => 6,
    ];
    const SEVEN = [
        'map' => [
            self::TOP,
            self::TOP_RIGHT,
            self::BOTTOM_RIGHT,
        ],
        'value' => 7,
    ];
    const EIGHT = [
        'map' => [
            self::TOP,
            self::TOP_LEFT,
            self::TOP_RIGHT,
            self::MIDDLE,
            self::BOTTOM_LEFT,
            self::BOTTOM_RIGHT,
            self::BOTTOM,
        ],
        'value' => 8,
    ];
    const NINE = [
        'map' => [
            self::TOP,
            self::TOP_LEFT,
            self::TOP_RIGHT,
            self::MIDDLE,
            self::BOTTOM_RIGHT,
            self::BOTTOM
        ],
        'value' => 9,
    ];
    const NUMBERS = [
        self::ZERO,
        self::ONE,
        self::TWO,
        self::THREE,
        self::FOUR,
        self::FIVE,
        self::SIX,
        self::SEVEN,
        self::EIGHT,
        self::NINE,
    ];

    public function getDayNumber(): string
    {
        return '8';
    }

    public function prepareInput($input)
    {
        return array_map(function (string $line) {
            $lineParts = preg_split('/\|/', $line);
            return [
                'first_part' => preg_split('/\s+/', trim($lineParts[0])),
                'second_part' => preg_split('/\s+/', trim($lineParts[1])),
            ];
        }, explode(PHP_EOL, trim($input)));
    }

    public function getFirstPartSolution($input): string
    {
        $count = 0;
        foreach ($input as $line) {
            foreach ($line['second_part'] as $string) {
                if (in_array(strlen($string), [2, 4, 3, 7])) {
                    $count++;
                }
            }
        }

        return (string)$count;
    }

    public function getSecondPartSolution($input): string
    {
        $sum = 0;
        foreach ($input as $line) {
            usort($line['first_part'], function ($string1, $string2) {
                return strlen($string1) <=> strlen($string2);
            });

            $sorted = [];
            $diffs = [];
            $commons = [];

            foreach(self::NUMBERS as $number) {
                $sorted[count($number['map'])][] = $number;
            }

            foreach ($sorted as $lettersCount => $numbers) {
                $all = [];

                foreach ($numbers as $number) {
                    $all = array_unique(array_merge($all, $number['map']));
                }

                $commonPart = $all;
                foreach ($numbers as $number) {
                    $commonPart = array_intersect($commonPart, $number['map']);
                }

                $diffs[$lettersCount] = array_diff($all, $commonPart);
                $commons[$lettersCount] = $commonPart;
            }

            $sortedLineStrings = [];
            foreach ($line['first_part'] as $string) {
                $sortedLineStrings[strlen($string)][] = $string;
            }

            $stringDiffs = [];
            $stringCommons = [];
            foreach ($sortedLineStrings as $length => $strings) {
                $all = [];

                foreach ($strings as $string) {
                    $all = array_unique(array_merge($all, str_split($string)));
                }

                $commonPart = $all;
                foreach ($strings as $string) {
                    $commonPart = array_intersect($commonPart, str_split($string));
                }

                $stringDiffs[$length] = array_diff($all, $commonPart);
                $stringCommons[$length] = $commonPart;
            }

            $possible = [
                self::TOP => self::POSITIONS,
                self::TOP_LEFT => self::POSITIONS,
                self::TOP_RIGHT => self::POSITIONS,
                self::MIDDLE => self::POSITIONS,
                self::BOTTOM_LEFT => self::POSITIONS,
                self::BOTTOM_RIGHT => self::POSITIONS,
                self::BOTTOM => self::POSITIONS,
            ];

            foreach ($commons as $lettersCount => $commonPositions) {
                foreach ($commonPositions as $commonPosition) {
                    $possible[$commonPosition] = array_intersect($possible[$commonPosition], $stringCommons[$lettersCount]);
                }
            }

            foreach ($diffs as $lettersCount => $commonPositions) {
                foreach ($commonPositions as $commonPosition) {
                    $possible[$commonPosition] = array_intersect($possible[$commonPosition], $stringDiffs[$lettersCount]);
                }
            }

            $toRemoveFromOthers = [];
            foreach ($possible as $position => $chars) {
                if (count($chars) === 1) {
                    $toRemoveFromOthers[$position] = $chars[array_key_first($chars)];
                }
            }

            foreach ($toRemoveFromOthers as $position => $char) {
                foreach ($possible as $positionPossible => $chars) {
                    if ($position === $positionPossible) {
                        continue;
                    }
                    if (in_array($char, $chars)) {
                        unset($possible[$positionPossible][array_search($char, $chars)]);
                    }
                }
            }

            $decodedMap = array_map(function ($possiblePositions) {
                return $possiblePositions[array_key_first($possiblePositions)];
            }, $possible);

            $decodedMap = array_flip($decodedMap);

            $number = '';
            foreach ($line['second_part'] as $string) {
                $number .= $this->findNumber($decodedMap, $string);;
            }
            $sum += (int)$number;
        }

        return (string)$sum;
    }

    private function findNumber(array $decodedMap, string $string): string
    {
        $decodedString = '';
        $decodedNumber = '';
        foreach (str_split($string) as $char) {
            $decodedString .= $decodedMap[$char];
        }

        foreach (self::NUMBERS as $number) {
            if (count($number['map']) === strlen($decodedString) && !count(array_diff($number['map'], str_split($decodedString)))) {
                $decodedNumber .= $number['value'];
            }
        }

        return $decodedNumber;
    }
}

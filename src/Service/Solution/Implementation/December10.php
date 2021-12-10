<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;

class December10 implements SolutionInterface
{
    private const OPENING_REGULAR = '(';
    private const CLOSING_REGULAR = ')';
    private const OPENING_SQUARE = '[';
    private const CLOSING_SQUARE = ']';
    private const OPENING_CURVED = '{';
    private const CLOSING_CURVED = '}';
    private const OPENING_TRIANGLE = '<';
    private const CLOSING_TRIANGLE = '>';

    private const SUPPORTED_CHARS = [
        self::OPENING_REGULAR,
        self::OPENING_REGULAR ,
        self::CLOSING_REGULAR ,
        self::OPENING_SQUARE,
        self::CLOSING_SQUARE ,
        self::OPENING_CURVED ,
        self::CLOSING_CURVED ,
        self::OPENING_TRIANGLE,
        self::CLOSING_TRIANGLE,
    ];

    private const OPENING_BRACKETS = [
        self::OPENING_REGULAR,
        self::OPENING_SQUARE,
        self::OPENING_CURVED,
        self::OPENING_TRIANGLE,
    ];

    private const CLOSING_TO_OPENING_MAP = [
        self::CLOSING_REGULAR => self::OPENING_REGULAR,
        self::CLOSING_SQUARE => self::OPENING_SQUARE,
        self::CLOSING_CURVED => self::OPENING_CURVED,
        self::CLOSING_TRIANGLE => self::OPENING_TRIANGLE,
    ];

    private const OPENING_TO_CLOSING_MAP = [
        self::OPENING_REGULAR => self::CLOSING_REGULAR ,
        self::OPENING_SQUARE => self::CLOSING_SQUARE,
        self::OPENING_CURVED => self::CLOSING_CURVED,
        self::OPENING_TRIANGLE => self::CLOSING_TRIANGLE,
    ];

    private const INCORRECT_CLOSING_SCORE_MAP = [
        self::CLOSING_REGULAR => 3,
        self::CLOSING_SQUARE => 57,
        self::CLOSING_CURVED => 1197,
        self::CLOSING_TRIANGLE => 25137,
    ];

    private const MISSING_CLOSINGS_SCORE_MAP = [
        self::CLOSING_REGULAR => 1,
        self::CLOSING_SQUARE => 2,
        self::CLOSING_CURVED => 3,
        self::CLOSING_TRIANGLE => 4,
    ];

    public function getDayNumber(): string
    {
        return '10';
    }

    public function prepareInput($input)
    {
        return explode(PHP_EOL, trim($input));
    }

    public function getFirstPartSolution($input): string
    {
        $totalScore = 0;
        foreach ($input as $line) {
            $incorrectClosing = $this->findIncorrectClosing($line);

            if (!$incorrectClosing) {
                continue;
            }

            $totalScore += self::INCORRECT_CLOSING_SCORE_MAP[$incorrectClosing];
        }

        return (string)$totalScore;
    }

    public function getSecondPartSolution($input): string
    {
        $incorrectLinesKeys = [];
        foreach ($input as $key => $line) {
            $incorrectClosing = $this->findIncorrectClosing($line);

            if (!$incorrectClosing) {
                continue;
            }

            $incorrectLinesKeys[] = $key;
        }

        foreach ($incorrectLinesKeys as $key) {
            unset($input[$key]);
        }

        $input = array_values($input);

        $scores = [];
        foreach ($input as $line) {
            $score = 0;
            $missingClosings = $this->findMissingClosings($line);

            foreach ($missingClosings as $missingClosing) {
                $score *= 5;
                $score += self::MISSING_CLOSINGS_SCORE_MAP[$missingClosing];
            }
            $scores[] = $score;
        }

        sort($scores);

        return (string)$scores[(array_key_first($scores) + array_key_last($scores)) / 2];
    }

    private function findIncorrectClosing($line): ?string
    {
        $openingsQueue = [];

        foreach (str_split($line) as $char) {
            if (!in_array($char, self::SUPPORTED_CHARS)) {
                continue;
            }
            if (in_array($char, self::OPENING_BRACKETS)) {
                $openingsQueue[] = $char;
            } else {
                $lastOpening = array_pop($openingsQueue);
                if ($lastOpening !== self::CLOSING_TO_OPENING_MAP[$char]) {
                    return $char;
                }
            }
        }

        return null;
    }

    private function findMissingClosings($line): array
    {
        $openingsQueue = [];

        foreach (str_split($line) as $char) {
            if (!in_array($char, self::SUPPORTED_CHARS)) {
                continue;
            }
            if (in_array($char, self::OPENING_BRACKETS)) {
                $openingsQueue[] = $char;
            } else {
                array_pop($openingsQueue);
            }
        }

        $missingClosings = [];

        while (count($openingsQueue)) {
            $missingClosings[] = self::OPENING_TO_CLOSING_MAP[array_pop($openingsQueue)];
        }

        return $missingClosings;
    }
}

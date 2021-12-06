<?php

declare(strict_types=1);

namespace App\Service\Solution\Implementation;

use App\Service\Solution\SolutionInterface;
use LogicException;

class December04 implements SolutionInterface
{
    public function getDayNumber(): string
    {
        return '4';
    }

    public function prepareInput($input): array
    {
        $stringNumbers = explode(PHP_EOL, trim($input))[0];
        $numbersCalled = explode(',', $stringNumbers);

        $boardsInput = trim(str_replace($stringNumbers, '', $input));

        $boards = explode(PHP_EOL . PHP_EOL, $boardsInput);

        foreach ($boards as $key => $stringBoard) {
            $boards[$key] = $this->buildArrayBoardFromString($stringBoard);
        }

        return [
            'numbers' => $numbersCalled,
            'boards' => $boards,
        ];
    }

    public function getFirstPartSolution($input): string
    {
        $numbersAlreadyCalled = [];

        foreach ($input['numbers'] as $numberCalled) {
            $numbersAlreadyCalled[] = $numberCalled;

            foreach ($input['boards'] as $board) {
                if ($this->hasBoardWon($board, $numbersAlreadyCalled)) {
                    return $this->getScore($board, $numbersAlreadyCalled);
                }
            }
        }

        throw new LogicException('No one has won :(');
    }

    public function getSecondPartSolution($input): string
    {
        $numbersAlreadyCalled = [];

        foreach ($input['numbers'] as $numberCalled) {
            $numbersAlreadyCalled[] = $numberCalled;

            foreach ($input['boards'] as $key => $board) {
                if ($this->hasBoardWon($board, $numbersAlreadyCalled)) {
                    if (1 === count($input['boards'])) {
                        return $this->getScore($board, $numbersAlreadyCalled);
                    }
                    unset($input['boards'][$key]);
                }
            }
        }

        throw new LogicException('Couldn\'t find solution');
    }

    private function buildArrayBoardFromString(string $stringBoard): array
    {
        $board = [];

        foreach (explode(PHP_EOL, $stringBoard) as $line => $stringBoardRow) {
            $i = 0;
            foreach (preg_split('/[\s]+/', trim($stringBoardRow)) as $char) {
                $board[$line][$i] = $char;
                $i++;
            }
        }

        return $board;
    }

    private function hasBoardWon(array $board, array $numbersAlreadyCalled): bool
    {
        $columnsCount = count($board[0]);
        $rowsCount= count($board);

        if (count($numbersAlreadyCalled) < $columnsCount && count($numbersAlreadyCalled) < $rowsCount) {
            return false;
        }

        foreach ($board as $row) {
            $count = 0;
            foreach ($row as $number) {
                if (in_array($number, $numbersAlreadyCalled)) {
                    $count++;
                }
                if ($count === $columnsCount) {
                    return true;
                }
            }
        }

        for ($i = 0; $i < $columnsCount; $i++) {
            $count = 0;
            foreach ($board as $row) {
                if (in_array($row[$i], $numbersAlreadyCalled)) {
                    $count++;
                }
                if ($count === $rowsCount) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getScore(array $board, array $numbersAlreadyCalled): string
    {
        $sum = 0;

        foreach ($board as $row) {
            foreach ($row as $columnChar) {
                if (!in_array($columnChar, $numbersAlreadyCalled)) {
                    $sum += (int)$columnChar;
                }
            }
        }

        return (string)($sum * (int)$numbersAlreadyCalled[array_key_last($numbersAlreadyCalled)]);
    }
}

<?php

declare(strict_types=1);

namespace App\Service\Solution;

interface SolutionInterface
{
    public function getDayNumber(): string;

    public function getFirstPartSolution($input): string;

    public function getSecondPartSolution($input): string;

    public function prepareInput($input);
}

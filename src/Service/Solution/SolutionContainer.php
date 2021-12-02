<?php

declare(strict_types=1);

namespace App\Service\Solution;

class SolutionContainer
{
    private $solutions = [];

    public function addSolution(SolutionInterface $solution): void
    {
        $this->solutions[] = $solution;
    }

    /**
     * @return array|SolutionInterface[]
     */
    public function getSolutions(): array
    {
        return $this->solutions;
    }
}

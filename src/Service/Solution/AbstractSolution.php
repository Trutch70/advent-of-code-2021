<?php

declare(strict_types=1);

namespace App\Service\Solution;

abstract class AbstractSolution implements SolutionInterface
{
    public function prepareInput($input)
    {
        return $input;
    }
}

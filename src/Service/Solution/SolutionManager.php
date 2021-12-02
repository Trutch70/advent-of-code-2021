<?php

declare(strict_types=1);

namespace App\Service\Solution;

use Exception;

class SolutionManager
{
    private $container;

    private $currentSolution;

    public function __construct(SolutionContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @throws Exception
     */
    public function init(string $day): void
    {
        foreach ($this->container->getSolutions() as $solution) {
            if ($solution->getDayNumber() === $day) {
                $this->currentSolution = $solution;
                return;
            }
        }

        throw new Exception(sprintf('Did not find the solution implementation for day %s', $day));
    }

    /**
     * @throws Exception
     */
    public function prepareInput($input)
    {
        $this->checkInitialization();
        return $this->currentSolution->prepareInput($input);
    }

    /**
     * @throws Exception
     */
    public function getFirstPartSolution($input): string
    {
        $this->checkInitialization();
        return $this->currentSolution->getFirstPartSolution($input);
    }

    /**
     * @throws Exception
     */
    public function getSecondPartSolution($input): string
    {
        $this->checkInitialization();
        return $this->currentSolution->getSecondPartSolution($input);
    }

    /**
     * @throws Exception
     */
    private function checkInitialization(): void
    {
        if (!$this->currentSolution instanceof SolutionInterface) {
            throw new Exception('Solution manager has not been initialized.');
        }
    }
}

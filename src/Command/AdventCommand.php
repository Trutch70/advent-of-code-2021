<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\Client\AdventClient;
use App\Service\Solution\SolutionManager;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AdventCommand extends Command
{
    protected static $defaultName = 'app:advent';

    protected $client;
    private $solutionManager;

    public function __construct(AdventClient $client, SolutionManager $solutionManager, string $name = null)
    {
        parent::__construct($name);
        $this->client = $client;
        $this->solutionManager = $solutionManager;
    }

    protected function configure()
    {
        $this->addArgument('day', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');

        try {
            $this->solutionManager->init($day);
            $input = $this->solutionManager->prepareInput($this->client->getInputByDay($day));

            $output->writeln(sprintf('solution to the first part: %s', $this->solutionManager->getFirstPartSolution($input)));

            $output->writeln(sprintf('solution to the second part: %s', $this->solutionManager->getSecondPartSolution($input)));

            return 0;
        } catch (Exception $e) {
            $output->writeln(sprintf('Error: %s', $e->getMessage()));
            return 1;
        }
    }
}

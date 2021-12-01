<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\AdventClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractAdventCommand extends Command
{
    private const INPUT_URL_PATTERN = 'https://adventofcode.com/2021/day/%s/input';

    protected $client;

    public function __construct(AdventClient $client, string $name = null)
    {
        parent::__construct($name);
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->client->get(sprintf(self::INPUT_URL_PATTERN, $this->getDayNumber()));
        $input = $this->prepareInput($response->getBody()->getContents());

        $output->writeln(sprintf('solution to the first part: %s', $this->getFirstPartSolution($input)));

        $output->writeln(sprintf('solution to the second part: %s', $this->getSecondPartSolution($input)));

        return 0;
    }

    protected function prepareInput($input)
    {
        return $input;
    }

    abstract protected function getDayNumber(): string;

    abstract protected function getFirstPartSolution($input): string;

    abstract protected function getSecondPartSolution($input): string;
}

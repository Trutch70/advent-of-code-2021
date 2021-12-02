<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use App\Service\Solution\SolutionContainer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SolutionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $solutionContainer = $container->findDefinition(SolutionContainer::class);

        $services = $container->findTaggedServiceIds('advent.solution');

        foreach ($services as $id => $service) {
            $solutionContainer->addMethodCall('addSolution', [new Reference($id)]);
        }
    }
}

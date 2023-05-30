<?php

declare(strict_types=1);

namespace Ergnuor\SerializerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * todo move class to separate package, so it could be shared between different packages
 */
trait DoctrineEntityManagerListDependencyTrait
{
    private function setDoctrineEntityManagersListDependency(
        ContainerBuilder $container,
        string $dependentServiceId,
        int|string $argumentIndex,
        string $expectedServiceClass
    ): void {
        $dependentServiceDefinition = $container->getDefinition($dependentServiceId);

        if ($dependentServiceDefinition->getClass() !== $expectedServiceClass) {
            return;
        }

        if (!$container->hasParameter('doctrine.entity_managers')) {
            throw new \RuntimeException(
                sprintf(
                    'Can not configure doctrine entity manager dependency for service "%s" with expected service class "%s": parameter "%s" is not exists. Possibly doctrine/orm is not installed',
                    $dependentServiceId,
                    $expectedServiceClass,
                    'doctrine.entity_managers'
                )
            );
        }

        $entityManagersServices = [];

        foreach ($container->getParameter('doctrine.entity_managers') as $entityManagerServiceId) {
            $entityManagersServices[] = new Reference($entityManagerServiceId);
        }

        $dependentServiceDefinition->replaceArgument($argumentIndex, $entityManagersServices);
    }
}

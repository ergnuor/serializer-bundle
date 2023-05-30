<?php

declare(strict_types=1);

namespace Ergnuor\SerializerBundle\DependencyInjection\Compiler;

use Ergnuor\Serializer\Normalizer\DoctrineEntityObjectNormalizer\DoctrineEntityClassMetadataGetter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class SerializerPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;
    use DoctrineEntityManagerListDependencyTrait;

    public function process(ContainerBuilder $container)
    {
        $this->configureDoctrineEntityNormalizer($container);
    }

    private function configureDoctrineEntityNormalizer(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('doctrine.entity_managers')) {
            return;
        }

        $this->setDoctrineEntityManagersListDependency(
            $container,
            'ergnuor.serializer.normalizer.doctrine_entity.class_metadata_getter',
            0,
            DoctrineEntityClassMetadataGetter::class,
        );
    }
}

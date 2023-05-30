<?php

declare(strict_types=1);

namespace Ergnuor\SerializerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

trait SerializerTrait
{
    use PriorityTaggedServiceTrait;

    private function setNormalizers(
        ContainerBuilder $container,
        string $serializerServiceId,
        string $normalizersTag,
        int $normalizersArgumentIndex = 0
    ): void {
        $normalizers = $this->findAndSortTaggedServices($normalizersTag, $container);

        if (!$normalizers) {
            throw new RuntimeException(
                sprintf(
                    'You must tag at least one service as "%s" to use the "%s" service.',
                    $normalizersTag,
                    $serializerServiceId
                )
            );
        }

        $serializerDefinition = $container->getDefinition($serializerServiceId);
        $serializerDefinition->replaceArgument($normalizersArgumentIndex, $normalizers);
    }
}

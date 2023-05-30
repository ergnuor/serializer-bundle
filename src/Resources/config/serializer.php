<?php
declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Ergnuor\Serializer\Normalizer\ObjectNormalizer;
use Ergnuor\Serializer\Normalizer\DoctrineCollectionNormalizer;
use Ergnuor\Serializer\Normalizer\DateTimeNormalizer;
use Ergnuor\Serializer\Normalizer\DoctrineEntityObjectNormalizer;
use Ergnuor\Serializer\Normalizer\DoctrineEntityObjectNormalizer\DoctrineEntityClassMetadataGetter;

return static function (ContainerConfigurator $container) {

    $container->services()
        ->set('ergnuor.serializer.normalizer.doctrine_entity.class_metadata_getter', DoctrineEntityClassMetadataGetter::class)
            ->args([[]])

        // normalizers

        ->set('ergnuor.serializer.normalizer.object', ObjectNormalizer::class)
            ->parent('serializer.normalizer.object')

        ->set('ergnuor.serializer.normalizer.collection', DoctrineCollectionNormalizer::class)

        ->set('ergnuor.serializer.normalizer.doctrine_entity', DoctrineEntityObjectNormalizer::class)
            ->args([
                service('ergnuor.serializer.normalizer.doctrine_entity.class_metadata_getter'),
                service('serializer.mapping.class_metadata_factory'),
                service('serializer.name_converter.metadata_aware'),
                service('serializer.property_accessor'),
                service('property_info')->ignoreOnInvalid(),
                service('serializer.mapping.class_discriminator_resolver')->ignoreOnInvalid(),
                null,
            ])
//            ->args([
//                [],
//                service('ergnuor.serializer.normalizer.doctrine_entity.class_metadata_getter')
//            ])

        ->set('ergnuor.serializer.normalizer.datetime', DateTimeNormalizer::class)
            ->parent('serializer.normalizer.datetime')

    ;
};

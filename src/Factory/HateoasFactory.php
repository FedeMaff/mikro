<?php

/**
 * HateoasFactory.php
 * Mikro\Factory\HateoasFactory
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Factory;

use Mikro\Hateoas\HateoasInterface;
use Mikro\Hateoas\WillDurandHateoasAdapter;
use Mikro\Settings;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy as NamingStrategy;
use Hateoas\HateoasBuilder;

/**
 * Factory di generazione istanze Serializzatore Hateoas
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class HateoasFactory
{
    /**
     * Generazione istanza chiave controller
     *
     * @return HateoasInterface
     */
    public static function create(): HateoasInterface
    {
        $serializer = SerializerBuilder::create()->setPropertyNamingStrategy(new NamingStrategy());
        $hateoas = HateoasBuilder::create($serializer)->addMetadataDir(YAML_DIR_PATH, '');
        foreach (Settings::getHateoasYamlDirsPaths() as $namespacePrefix => $path) {
            $hateoas = $hateoas->addMetadataDir($path, $namespacePrefix);
        }
        $hateoas = $hateoas->build();
        return new WillDurandHateoasAdapter($hateoas);
    }
}

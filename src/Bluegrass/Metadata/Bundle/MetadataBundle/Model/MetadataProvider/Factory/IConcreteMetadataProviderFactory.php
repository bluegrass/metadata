<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

/**
 * Especifica la interfaz que debe implementar un factory para un proveedor
 * de metadatos concreto.
 * 
 * @author gcaseres
 */
interface IConcreteMetadataProviderFactory {
    public function create();
}

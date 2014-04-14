<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;

/**
 * Genera instancias concretas de Valores de Metadatatos
 * @author ldelia
 */
interface IMetadataValueFactory
{
    
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity $entity
     * @param string $metadataName
     * @param type $value
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createMetadataValue( IMetadataEntity $entity, $metadataName, $value );    
}

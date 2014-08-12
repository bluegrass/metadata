<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue;

/**
 * Genera/Recupera valores para Metadatos
 * @author ldelia
 */
interface IMetadataValueProvider
{    
    /**
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createValue( IMetadataEntity $entity, Metadata $metadata, $value );
    
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue $metadataValue
     */
    public function getValue( IMetadataValue $metadataValue );
    
    /**
     * 
     * @param mixed $value
     * @return mixed
     */
    public function normalizeValue( $value );
}

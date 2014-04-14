<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
/**

 *
 * @author ldelia
 */
class RawMetadataValueProvider extends MetadataValueProvider
{        
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue $metadataValue
     */
    public function getValue( IMetadataValue $metadataValue )
    {
        return $metadataValue->getValue();
    }    
    
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity $entity
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @param type $value
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createValue( IMetadataEntity $entity, Metadata $metadata, $value )
    {
        return $this->getMetadataValueFactory()->createMetadataValue($entity, $metadata->getName(), $value);
    }
}


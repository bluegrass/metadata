<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue;

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
    
    public function normalizeValue( $value )
    {
        return $value;
    }    
}


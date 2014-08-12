<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

/**
 *
 * @author ldelia
 */
interface IMetadataProvider
{
    public function getMetadata( $metadataName );
    
    public function hasMetadata( $metadataName );
}

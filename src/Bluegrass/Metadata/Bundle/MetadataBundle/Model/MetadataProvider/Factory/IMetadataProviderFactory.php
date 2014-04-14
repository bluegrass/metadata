<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

/**
 *
 * @author ldelia
 */
interface IMetadataProviderFactory
{
    public function getProviderFor( $className );
}

<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;

/**
 *
 * @author ldelia
 */
abstract class MetadataValueProvider implements IMetadataValueProvider
{
    protected $metadataValueFactory;
    
    public function __construct(IMetadataValueFactory $metadataValueFactory)
    {
       $this->setMetadataValueFactory($metadataValueFactory) ;
    }
    
    /**
     * 
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory
     */
    public function getMetadataValueFactory()
    {
        return $this->metadataValueFactory;
    }

    public function setMetadataValueFactory( IMetadataValueFactory $metadataValueFactory)
    {
        $this->metadataValueFactory = $metadataValueFactory;
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
        return $this->getMetadataValueFactory()->createMetadataValue( $entity, $metadata->getName(), $this->normalizeValue( $value ) );
    }    
}


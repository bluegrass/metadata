<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider;

/**
 * Representa el controller de la especificación de un metadato
 *
 * @author ldelia
 */
class Metadata
{
    private $provider;
    private $name;
    
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider $provider
     * @param string $name
     */
    public function __construct(IMetadataValueProvider $provider, $name )
    {
        $this->setName($name);
        $this->setProvider($provider);
    }
    
    /**
     * 
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider $provider
     */
    protected function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function getName()
    {
        return $this->name;
    }

    protected function setName($name)
    {
        $this->name = $name;
    }    
    
    public function getValue(IMetadataValue $metadataValue )
    {
        return $this->getProvider()->getValue($metadataValue);
    }
    
    public function createValue( IMetadataEntity $entity, $value )
    {
        return $this->getProvider()->createValue($entity, $this, $value);
    }
    
    public function normalizeValue( $value )
    {
        return $this->getProvider()->normalizeValue( $value );
    }
    
    public function __toString()
    {
        return $this->getName();
    }
}
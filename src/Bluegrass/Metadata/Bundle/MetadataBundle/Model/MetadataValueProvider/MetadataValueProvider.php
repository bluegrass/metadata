<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

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

}


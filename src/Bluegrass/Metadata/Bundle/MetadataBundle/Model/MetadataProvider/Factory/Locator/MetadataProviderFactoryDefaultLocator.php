<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\Locator;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\Locator\IMetadataProviderFactoryLocator;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\IConcreteMetadataProviderFactory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;


class MetadataProviderFactoryDefaultLocator implements IMetadataProviderFactoryLocator 
{
    protected $metadataProviderFactories;
    
    public function __construct()
    {
        $this->metadataProviderFactories = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function setMetadataProviderFactory( $source, IConcreteMetadataProviderFactory $metadataProviderFactory)
    {
        $this->metadataProviderFactories[ $source ] = $metadataProviderFactory;
    }
    
    public function  lookupMetadataProviderFactoryForEntityTableMetadata( EntityTableMetadata $tableMetadata )
    {
        if( isset( $this->metadataProviderFactories[ $tableMetadata->getEntityType() ] ) ){
            return $this->metadataProviderFactories[ $tableMetadata->getEntityType() ];
        }else{
            return null;
        }
    }
    
    public function  lookupMetadataProviderFactoryForLogicTableMetadata( LogicTableMetadata $tableMetadata )
    {
        if( isset( $this->metadataProviderFactories[ $tableMetadata->getName() ] ) ){
            return $this->metadataProviderFactories[ $tableMetadata->getName() ];
        }else{
            return null;
        }        
    }
}

    
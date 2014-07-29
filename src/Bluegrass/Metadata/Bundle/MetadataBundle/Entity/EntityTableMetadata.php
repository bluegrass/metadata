<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Entity;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\IMetadataProviderFactory;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class EntityTableMetadata extends TableMetadata
{
    /** @ORM\Column(type="string") */    
    protected $entityType;

    public function __construct( $entityType )
    {
        parent::__construct();
        $this->setEntityType($entityType);
    }
    
    public function getEntityType()
    {
        return $this->entityType;
    }

    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }    
    
    /**
     * 
     * {@inheritdoc }
     */
    public function getMetadataProviderFromFactory(IMetadataProviderFactory $providerFactory) 
    {
        return $providerFactory->getProviderForEntityTable($this);
    }     
    
    public function __toString()
    {
        return $this->getEntityType();
    }
}


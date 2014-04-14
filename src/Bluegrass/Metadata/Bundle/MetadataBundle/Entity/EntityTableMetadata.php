<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Entity;

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
}


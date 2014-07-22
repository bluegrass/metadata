<?php

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\MetadataProvider;

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\MetadataProvider;

use Doctrine\ORM\EntityManager;

/**
 * Provee metadatos para una entidad.
 *
 * @author ldelia
 */

class EntityTableMetadataProvider extends MetadataProvider {

    protected $entityType;
    
    public function __construct(EntityManager $em, $entityType, $metadataValueFactory)
    {        
        parent::__construct($em);
        
        $this->setEntityType($entityType);
        
        $this->setMetadataValueFactory( $metadataValueFactory );
    }

    protected function setEntityType( $entityType )
    {
        $this->entityType = $entityType;                
    }
    
    public function getEntityType()            
    {
        return $this->entityType;
    }
}

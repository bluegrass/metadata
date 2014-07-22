<?php

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
    
    protected function getTableMetadata() {
        $entityTableMetadata = $this->getEm()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata')->findOneByEntityType($this->getEntityType());

        if (is_null($entityTableMetadata)) {
            throw new Exception('No se encontró la estructura de metadatos asociada a la entidad ' . $this->getEntityType());
        }

        return $entityTableMetadata;
    }

}

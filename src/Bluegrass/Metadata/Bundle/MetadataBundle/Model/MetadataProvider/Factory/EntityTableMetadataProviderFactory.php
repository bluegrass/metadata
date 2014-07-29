<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\EntityTableMetadataProvider;
use Doctrine\ORM\EntityManager;

/**
 * Factory para EntityTableMetadataProvider.
 * 
 * Esta factory implementa IConcreteMetadataProviderFactory para facilitar
 * la generación de instancias de EntityTableMetadataProvider a partir de un
 * IMetadataProviderFactory.
 *
 * @author gcaseres
 */
class EntityTableMetadataProviderFactory implements IConcreteMetadataProviderFactory {
    
    protected $em;
    protected $entityType;
    protected $metadataValueFactory;
    
    public function __construct(EntityManager $em, $entityType, $metadataValueFactory) {
        $this->em = $em;
        $this->entityType = $entityType;
        $this->metadataValueFactory = $metadataValueFactory;
    }
    
    public function create() 
    {
        return new EntityTableMetadataProvider($this->em, $this->entityType, $this->metadataValueFactory);
    }

}

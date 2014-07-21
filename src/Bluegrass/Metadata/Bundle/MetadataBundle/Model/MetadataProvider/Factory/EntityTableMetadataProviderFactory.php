<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

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
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function create() {
        return new EntityTableMetadataProvider($this->em);
    }

}

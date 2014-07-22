<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Doctrine\ORM\EntityManager;

/**
 * Factory para LogicTableMetadataProvider.
 * 
 * Esta factory implementa IConcreteMetadataProviderFactory para facilitar
 * la generación de instancias de LogicTableMetadataProvider a partir de un
 * IMetadataProviderFactory.
 *
 * @author gcaseres
 */
class LogicTableMetadataProviderFactory implements IConcreteMetadataProviderFactory {
    
    protected $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function create() {
        return new LogicTableMetadataProvider($this->em);
    }

}

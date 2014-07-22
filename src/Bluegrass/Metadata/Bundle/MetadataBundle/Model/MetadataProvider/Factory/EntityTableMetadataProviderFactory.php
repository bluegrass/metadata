<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\EntityTableMetadataProvider;

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
    
    protected $metadataProvider;
    
    public function __construct(EntityTableMetadataProvider $metadataProvider) {
        $this->metadataProvider = $metadataProvider;
    }
    
    public function create() {
        /** @todo Este metodo podría no existir más */
        return $this->metadataProvider;
    }

}

<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\Locator;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;

/**
 *
 * @author ldelia
 */
interface IMetadataProviderFactoryLocator
{
    /**
     * Obtiene una factory de proveedor de metadatos para una especificación de tabla con
     * atributos dinámicos.
     * 
     * @param EntityTableMetadata $entityTableMetadata
     * @return IConcreteMetadataProviderFactory | null
     */    
    public function  lookupMetadataProviderFactoryForEntityTableMetadata( EntityTableMetadata $tableMetadata );

    /**
     * Obtiene una factory de proveedor de metadatos para una especificación de tabla con
     * atributos dinámicos.
     * 
     * @param EntityTableMetadata $entityTableMetadata
     * @return IConcreteMetadataProviderFactory | null
     */    
    public function  lookupMetadataProviderFactoryForLogicTableMetadata( LogicTableMetadata $tableMetadata );
}

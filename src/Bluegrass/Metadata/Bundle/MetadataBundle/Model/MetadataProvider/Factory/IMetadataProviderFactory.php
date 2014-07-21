<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider;

/**
 *
 * @author ldelia
 */
interface IMetadataProviderFactory
{
    /**
     * Obtiene un proveedor de metadatos para una especificación de tabla con
     * atributos dinámicos.
     * 
     * @param string|TableMetadata $tableMetadata 
     * @return IMetadataProvider
     */
    public function getProviderFor( $tableMetadata );

    /**
     * Obtiene un proveedor de metadatos a partir de una especificación de 
     * metadatos para tablas lógicas.
     * 
     * @param LogicTableMetadata $logicTableMetadata 
     * @return IMetadataProvider
     */    
    public function getProviderForLogicTable(LogicTableMetadata $logicTableMetadata);

     /**
     * Obtiene un proveedor de metadatos a partir de una especificación de 
     * metadatos para tablas basadas en entidades.
     * 
     * @param EntityTableMetadata $entityTableMetadata 
     * @return IMetadataProvider
     */    
    public function getProviderForEntityTable(EntityTableMetadata $entityTableMetadata);
}

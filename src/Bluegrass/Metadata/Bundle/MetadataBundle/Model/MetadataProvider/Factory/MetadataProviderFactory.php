<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\Locator\IMetadataProviderFactoryLocator;

use Exception;

/**
 * Genera instancias de MetadataProvider a partir de una especificación de 
 * tabla de atributos dinámicos o una clave de identificación.
 *
 * @author ldelia
 */

class MetadataProviderFactory implements IMetadataProviderFactory 
{
    protected $metadataProviderFactoryLocators;
    
    /**
     * 
     * {@inheritdoc }
     */
    
    /**
     * Establece un Localizador de factory de proveedores de metadatos.
     * 
     * @param IMetadataProviderFactoryLocator $metadataProviderFactoryLocator
     */
    public function setMetadataProviderFactoryLocator(IMetadataProviderFactoryLocator $metadataProviderFactoryLocator) 
    {
        $this->metadataProviderFactoryLocators[] = $metadataProviderFactoryLocator;
    }

    /**
     * Obtiene un proveedor de metadatos a partir de una especificación de tabla
     * de atributos dinámicos.
     * 
     * @param TableMetadata $tableMetadata
     * @return IMetadataProvider
     */    
    public function getMetadataProviderFor(TableMetadata $tableMetadata ) 
    {        
        return $tableMetadata->getMetadataProviderFromFactory($this);        
    }
    
    /**
     * Obtiene un proveedor de metadatos asociado a la especificación de tabla
     * de atributos dinámicos especificada.
     * 
     * @param EntityTableMetadata $entityTableMetadata Tabla de atributos dinámicos basada en entidad.
     * @return IMetadataProvider
     */
    public function getProviderForEntityTable(EntityTableMetadata $tableMetadata) 
    {
        /* @var $metadataProviderFactoryLocator IMetadataProviderFactoryLocator */
        foreach( $this->metadataProviderFactoryLocators as $metadataProviderFactoryLocator )
        {
            /* @var $metadataProviderFactory IConcreteMetadataProviderFactory */
            $metadataProviderFactory = $metadataProviderFactoryLocator->lookupMetadataProviderFactoryForEntityTableMetadata($tableMetadata);
            if( !is_null($metadataProviderFactory) ){
                return $metadataProviderFactory->create();    
            }
        }
        
        throw new Exception("No se encuentra definido un MetadataProvider para el TableMetadata " . $tableMetadata);
    }

    /**
     * Obtiene un proveedor de metadatos asociado a la especificación de tabla
     * de atributos dinámicos especificada.
     * 
     * @param EntityTableMetadata $logicTableMetadata Tabla de atributos dinámicos.
     * @return IMetadataProvider
     */    
    public function getProviderForLogicTable(LogicTableMetadata $tableMetadata) 
    {
        /* @var $metadataProviderFactoryLocator IMetadataProviderFactoryLocator */
        foreach( $this->metadataProviderFactoryLocators as $metadataProviderFactoryLocator )
        {
            /* @var $metadataProviderFactory IConcreteMetadataProviderFactory */
            $metadataProviderFactory = $metadataProviderFactoryLocator->lookupMetadataProviderFactoryForLogicTableMetadata($tableMetadata);
            if( !is_null($metadataProviderFactory) ){
                return $metadataProviderFactory->create();    
            }
        }
        
        throw new Exception("No se encuentra definido un MetadataProvider para el TableMetadata " . $tableMetadata);
    }
}
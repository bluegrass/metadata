<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider;
use Exception;

/**
 * Genera instancias de MetadataProvider a partir de una especificación de 
 * tabla de atributos dinámicos o una clave de identificación.
 *
 * @author ldelia
 */
class MetadataProviderFactory implements IMetadataProviderFactory {

    protected $metadataProviders;

    /**
     * 
     * {@inheritdoc }
     */
    public function getProviderFor($tableMetadata) {
        if (is_string($tableMetadata)) {
            return $this->getProviderForKey($tableMetadata);
        } else {
            return $this->getProviderForTableMetadata($tableMetadata);
        }
    }
    
    /**
     * Obtiene un proveedor de metadatos a partir de una especificación de tabla
     * de atributos dinámicos.
     * 
     * @param TableMetadata $tableMetadata
     * @return IMetadataProvider
     */
    public function getProviderForTableMetadata(TableMetadata $tableMetadata) {
        return $tableMetadata->getMetadataProviderFromFactory($this);
    }

    
    /**
     * Obtiene un proveedor de metadatos a partir de una clave de identificación.
     * 
     * @param string $key
     * @return IMetadataProvider
     * @throws Exception
     */
    public function getProviderForKey($key) {
        if (isset($this->metadataProviders[$key])) {

            /* @var $metadataProviderFactory IConcreteMetadataProviderFactory */
            $metadataProviderFactory = $this->metadataProviders[$key];
            return $metadataProviderFactory->create();
        } else {
            throw new Exception("No se encuentra definido un Metadata Provider para la clave " . $key);
        }
    }

    
    /**
     * Establece una factory de proveedores de metadatos asociado a la clave
     * especificada.
     * 
     * @param string $key
     * @param IConcreteMetadataProviderFactory $metadataProviderFactory
     */
    public function setProvider($key, IConcreteMetadataProviderFactory $metadataProviderFactory) {
        $this->metadataProviders[$key] = $metadataProviderFactory;
    }

    /**
     * Obtiene un proveedor de metadatos asociado a la especificación de tabla
     * de atributos dinámicos especificada.
     * 
     * @param EntityTableMetadata $entityTableMetadata Tabla de atributos dinámicos basada en entidad.
     * @return IMetadataProvider
     */
    public function getProviderForEntityTable(EntityTableMetadata $entityTableMetadata) {
        return $this->getProviderForKey($entityTableMetadata->getEntityType());
    }

    /**
     * Obtiene un proveedor de metadatos asociado a la especificación de tabla
     * de atributos dinámicos especificada.
     * 
     * @param EntityTableMetadata $logicTableMetadata Tabla de atributos dinámicos.
     * @return IMetadataProvider
     */    
    public function getProviderForLogicTable(LogicTableMetadata $logicTableMetadata) {
        return $this->getProviderForKey($logicTableMetadata->getName());
    }

}

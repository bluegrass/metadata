<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;
use Doctrine\ORM\EntityManager;
use Exception;

/**
 * Genera instancias de MetadataProvider según una instancia concreta
 *
 * @author ldelia
 */
class MetadataProviderFactory implements IMetadataProviderFactory {

    protected $metadataProviders;
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

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
    
    public function getProviderForTableMetadata(TableMetadata $tableMetadata) {
        return $tableMetadata->getMetadataProviderFromFactory($this);
    }

    public function getProviderForKey($metadataTableKey) {
        if (isset($this->metadataProviders[$metadataTableKey])) {

            /* @var $metadataProviderFactory IConcreteMetadataProviderFactory */
            $metadataProviderFactory = $this->metadataProviders[$metadataTableKey];
            return $metadataProviderFactory->create();
        } else {
            throw new Exception("No se encuentra definido un Metadata Provider para la entidad " . $metadataTableKey);
        }
    }

    public function setProvider($metadataEntityClassName, IConcreteMetadataProviderFactory $metadataProviderFactory) {
        $this->metadataProviders[$metadataEntityClassName] = $metadataProviderFactory;
    }

    public function getProviderForEntityTable(EntityTableMetadata $entityTableMetadata) {
        return $this->getProviderForKey($entityTableMetadata->getEntityType());
    }

    public function getProviderForLogicTable(LogicTableMetadata $logicTableMetadata) {
        return $this->getProviderForKey($logicTableMetadata->getName());
    }

}

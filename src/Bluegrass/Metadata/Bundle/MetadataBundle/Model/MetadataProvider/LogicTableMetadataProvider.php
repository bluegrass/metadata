<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\MetadataProvider;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;
use Doctrine\ORM\EntityManager;

/**
 * Description of LogicTableMetadataProvider
 *
 * @author gcaseres
 */
class LogicTableMetadataProvider extends MetadataProvider {

    protected $logicTableName;
    
    public function __construct(EntityManager $em, $tableName, IMetadataValueFactory $metadataValueFactory) 
    {
        parent::__construct($em);
        $this->logicTableName = $tableName;
        $this->setMetadataValueFactory($metadataValueFactory);
    }
    
    protected function getTableName() 
    {
        return $this->logicTableName;
    }

    /**
     * 
     * {@inherit}
     */
    protected function getTableMetadata() 
    {
        $tableMetadata = $this->getEm()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata')->findOneByName($this->getTableName());
        
        if (is_null($tableMetadata)) {
            throw new Exception('No se encontró la estructura de metadatos con nombre ' . $this->getTableName());
        }

        return $tableMetadata;
    }
}
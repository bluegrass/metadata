<?php

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\MetadataProvider;
use Doctrine\ORM\EntityManager;

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

/**
 * Description of LogicTableMetadataProvider
 *
 * @author gcaseres
 */
class LogicTableMetadataProvider extends MetadataProvider {

    protected $logicTableName;
    
    public function __construct(EntityManager $em, $tableName) {
        parent::__construct($em);
        $this->logicTableName = $tableName;
    }
    
    protected function getTableName() {
        return $this->logicTableName;
    }

    /**
     * 
     * {@inherit}
     */
    protected function getTableMetadata() {
        $tableMetadata = $this->getEm()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata')->findOneByName($this->getTableName());
        
        if (is_null($tableMetadata)) {
            throw new Exception('No se encontró la estructura de metadatos con nombre ' . $this->getTableName());
        }

        return $tableMetadata;
    }

}

<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\TableMetadataManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;

/**
 * Description of DoctrineTableMetadataManager
 *
 * @author gcaseres
 */
class DoctrineTableMetadataManager implements ITableMetadataManager {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function deleteTableMetadata(TableMetadata $tableMetadata) {
        $this->em->remove($tableMetadata);

        if ($tableMetadata instanceof LogicTableMetadata) {
            /* @var LogicTableMetadata $logicTableMetadata */
            $logicTableMetadata = $tableMetadata;
            $conn = $this->em->getConnection();
            
            $conn->getSchemaManager()->dropTable($logicTableMetadata->getName());
        }        
    }

    public function persistTableMetadata(TableMetadata $tableMetadata) {
        $this->em->persist($tableMetadata);
        
        if ($tableMetadata instanceof LogicTableMetadata) {
            
            /* @var LogicTableMetadata $logicTableMetadata */
            $logicTableMetadata = $tableMetadata;
            $conn = $this->em->getConnection();
            $platform = $conn->getDatabasePlatform();
            
            $schema = new Schema();
            $table = $schema->createTable($logicTableMetadata->getName());
            foreach ($logicTableMetadata->getAttributes() as $attribute) {
                $table->addColumn($attribute->getName(), $attribute->getType());
            }
            
            $result_sql = $schema->toSql($platform);            
            foreach ($result_sql as $sql) {
                //$conn->exec($sql);
            }
        }        
    }

}

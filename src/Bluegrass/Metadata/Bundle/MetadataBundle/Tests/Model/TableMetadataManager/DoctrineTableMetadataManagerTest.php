<?php
namespace Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Model\TableMetadataManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\AttributeMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\TableMetadataManager\DoctrineTableMetadataManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


/**
 * Description of DoctrineTableMetadataManagerTest
 *
 * @author gcaseres
 */
class DoctrineTableMetadataManagerTest extends KernelTestCase {

    private $em;

    public function setUp() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testPersistLogicTableMetadata() {
        $tableMetadataManager = new DoctrineTableMetadataManager($this->em);
        
        $tableMetadata = new LogicTableMetadata();
        $tableMetadata->setName('test_table');
        $tableMetadata->addAttribute(new AttributeMetadata("id", "integer"));
        $tableMetadata->addAttribute(new AttributeMetadata("nombre", "string"));
        
        $tableMetadataManager->persistTableMetadata($tableMetadata);
    }
}

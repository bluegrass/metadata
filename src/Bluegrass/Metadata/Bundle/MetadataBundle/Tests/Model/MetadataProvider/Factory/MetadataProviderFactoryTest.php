<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Model\MetadataProvider\Factory;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\LogicTableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\MetadataProviderFactory;

/**
 *
 * @author gcaseres
 */
class MetadataProviderFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {

        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);

        new MetadataProviderFactory($em);
    }

    public function testGetProviderForWithLogicTable() {
        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $tableMetadata = new LogicTableMetadata('table_1');
        $logicTableMetadataProviderFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\LogicTableMetadataProviderFactory', array(), array(), '', false);
        $logicTableMetadataProvider = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\LogicTableMetadataProvider', array(), array(), '', false);

        $logicTableMetadataProviderFactory->expects($this->once())
                ->method('create')
                ->will($this->returnValue($logicTableMetadataProvider));

        $metadataProviderFactory = new MetadataProviderFactory($em);

        $metadataProviderFactory->setProvider($tableMetadata->getName(), $logicTableMetadataProviderFactory);

        $this->assertEquals($logicTableMetadataProvider, $metadataProviderFactory->getProviderFor($tableMetadata));
    }
    
    public function testGetProviderForWithEntityTable() {
        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $tableMetadata = new EntityTableMetadata('entitytype_1');
        $entityTableMetadataProviderFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\EntityTableMetadataProviderFactory', array(), array(), '', false);
        $entityTableMetadataProvider = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\EntityTableMetadataProvider', array(), array(), '', false);

        $entityTableMetadataProviderFactory->expects($this->once())
                ->method('create')
                ->will($this->returnValue($entityTableMetadataProvider));

        $metadataProviderFactory = new MetadataProviderFactory($em);

        $metadataProviderFactory->setProvider($tableMetadata->getEntityType(), $entityTableMetadataProviderFactory);

        $this->assertEquals($entityTableMetadataProvider, $metadataProviderFactory->getProviderFor($tableMetadata));
    }    

}

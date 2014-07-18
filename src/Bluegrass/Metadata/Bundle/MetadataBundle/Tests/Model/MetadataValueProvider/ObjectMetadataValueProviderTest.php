<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Model\MetadataValueProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\ObjectMetadataValueProvider;
use DateTime;

/**
 * Description of ObjectMetadataValueProviderTest
 *
 * @author gcaseres
 */
class ObjectMetadataValueProviderTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {
        $entityType = 'entity_type-test';
        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $metadataValueFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory');

        new ObjectMetadataValueProvider($metadataValueFactory, $em, $entityType);
    }

    public function testGetValue() {
        $value = new DateTime();
        $entityType = 'entity_type-test';
        $metadataValueFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory');
        $metadataValue = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue');
        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $repository = $this->getMock('Doctrine\ORM\EntityRepository', array(), array(), '', false);

        $metadataValue->expects($this->once())
                ->method('getValue')
                ->will($this->returnValue($value));

        $em->expects($this->once())
                ->method('getRepository')
                ->with($this->equalTo($entityType))
                ->will($this->returnValue($repository));

        $repository->expects($this->once())
                ->method('find')
                ->will($this->returnValue($value));

        $metadataValueProvider = new ObjectMetadataValueProvider($metadataValueFactory, $em, $entityType);

        $result = $metadataValueProvider->getValue($metadataValue);

        $this->assertNotNull($result);
        $this->assertEquals($result, $value);
    }

    public function testCreateValue() {
        $id = 150;
        $entityType = 'Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Utils\EntityMock';
        $entity = $this->getMock($entityType);
        $metadataValueFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory');
        $metadataValue = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue');
        $em = $this->getMock('Doctrine\ORM\EntityManager', array(), array(), '', false);
        $metadataEntity = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity');
        $metadata = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata', array(), array(), '', false);
        
        $entity->expects($this->any())
                ->method('getId')
                ->will($this->returnValue($id));
        
        $metadataValue->expects($this->once())
                ->method('getValue')
                ->will($this->returnValue($entity));

        $metadataValueFactory->expects($this->once())
                ->method('createMetadataValue')
                ->will($this->returnValue($metadataValue));
        
        $metadataValueProvider = new ObjectMetadataValueProvider($metadataValueFactory, $em, $entityType);

        $result = $metadataValueProvider->createValue($metadataEntity, $metadata, $entity);

        $this->assertNotNull($result);
        $this->assertEquals($result->getValue()->getId(), $entity->getId());
    }

}

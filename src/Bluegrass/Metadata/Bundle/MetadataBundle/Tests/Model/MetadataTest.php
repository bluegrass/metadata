<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Model;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;

/**
 * Description of MetadataTest
 *
 * @author gcaseres
 */
class MetadataTest extends \PHPUnit_Framework_TestCase {

    public function testCreate() {
        $name = 'testMetadata';
        $metadataValueProvider = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider');

        new Metadata($metadataValueProvider, $name);
    }

    public function testGetValue() {
        $name = 'testMetadata';

        $metadataValue = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue');
        $metadataValueProvider = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider');


        $metadataValueProvider->expects($this->any())
                ->method('getValue')
                ->will($this->returnValue('test-string'));

        $metadata = new Metadata($metadataValueProvider, $name);

        $result = $metadata->getValue($metadataValue);

        $this->assertEquals($result, 'test-string');
    }

    public function testCreateValue() {
        $name = 'testMetadata';
        $metadataValue = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue');
        $metadataValueProvider = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\IMetadataValueProvider');
        $metadataEntity = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity');
        $value = 'test-string';
        $metadata = new Metadata($metadataValueProvider, $name);

        $metadataValueProvider->expects($this->once())
                ->method('createValue')
                ->with($this->equalTo($metadataEntity), $this->equalTo($metadata), $this->equalTo($value))
                ->will($this->returnValue($metadataValue));

        $metadataValue->expects($this->any())
                ->method('getValue')
                ->will($this->returnValue($value));


        $result = $metadata->createValue($metadataEntity, $value);

        $this->assertNotNull($result);
        $this->assertEquals($result->getValue(), $value);
    }        

}

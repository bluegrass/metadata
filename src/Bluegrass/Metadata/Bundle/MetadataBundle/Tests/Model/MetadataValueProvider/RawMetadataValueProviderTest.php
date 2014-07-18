<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Model\MetadataValueProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\RawMetadataValueProvider;


/**
 * Description of RawMetadataValueProviderTest
 *
 * @author gcaseres
 */
class RawMetadataValueProviderTest  extends \PHPUnit_Framework_TestCase {
    
    public function testCreate() {
        $metadataValueFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory');
        new RawMetadataValueProvider($metadataValueFactory);
    }
    
    public function testGetValue() {
        $value = 'test-value';
        $metadataValueFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory');
        $metadataValue = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue');        
        
        $metadataValue->expects($this->once())
                ->method('getValue')
                ->will($this->returnValue($value));
        
        $metadataValueProvider = new RawMetadataValueProvider($metadataValueFactory);
        
        $result = $metadataValueProvider->getValue($metadataValue);
        
        $this->assertNotNull($result);
        $this->assertEquals($result, $value);
    }
    
    public function testCreateValue() {
        $value = 'test-value';
        $metadataValueFactory = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory');
        $metadataValue = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue');        
        $metadataEntity = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity');        
        $metadata = $this->getMock('Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata', array(), array(), '', false);
        
        $metadataValue->expects($this->once())
                ->method('getValue')
                ->will($this->returnValue($value));
        
        $metadataValueFactory->expects($this->once())
                ->method('createMetadataValue')
                ->will($this->returnValue($metadataValue));
        
        $metadataValueProvider = new RawMetadataValueProvider($metadataValueFactory);
        
        $result = $metadataValueProvider->createValue($metadataEntity, $metadata, $value);
        
        $this->assertNotNull($result);
        $this->assertEquals($result->getValue(), $value);
    }    
    
    
}

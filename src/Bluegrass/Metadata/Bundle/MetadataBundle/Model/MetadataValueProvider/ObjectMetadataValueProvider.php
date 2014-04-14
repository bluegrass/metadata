<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;

use Doctrine\ORM\EntityManager;
/**

 *
 * @author ldelia
 */
class ObjectMetadataValueProvider extends MetadataValueProvider
{
    protected $em;
    protected $entityType;
    
    public function __construct(IMetadataValueFactory $metadataValueFactory, EntityManager $em, $entityType)
    {
        parent::__construct($metadataValueFactory);
        $this->setEm($em);
        $this->setEntityType($entityType);
    }
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEm()
    {
        return $this->em;
    }

    protected function setEm($em)
    {
        $this->em = $em;
    }
    
    public function getEntityType()
    {
        return $this->entityType;
    }

    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }
    
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue $metadataValue
     */
    public function getValue( IMetadataValue $metadataValue )
    {
        $entity = $this->getEm()->getRepository( $this->getEntityType() )->find( $metadataValue->getValue() );
        return $entity;
    }    
    
    /**
     * 
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataEntity $entity
     * @param \Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata $metadata
     * @param type $value
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\IMetadataValue 
     */
    public function createValue( IMetadataEntity $entity, Metadata $metadata, $value )
    {
        return $this->getMetadataValueFactory()->createMetadataValue( $entity, $metadata->getName(), $value->getId() );
    }
}


<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider;

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
    
    public function normalizeValue( $value )
    {
        return $value->getId();
    }
}


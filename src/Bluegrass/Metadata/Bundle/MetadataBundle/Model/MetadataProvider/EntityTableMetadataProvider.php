<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

use Doctrine\ORM\EntityManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\RawMetadataValueProvider;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\ObjectMetadataValueProvider;

/**
 * Provee metadatos para una entidad
 *
 * @author ldelia
 */
abstract class EntityTableMetadataProvider implements IMetadataProvider
{
    protected $em;
    protected $metadataValueFactory = null;
    protected $metadata = null;
    
    public function __construct(EntityManager $em)
    {
        $this->setEm($em);
    }
    
    abstract function getEntityType();    
    
    protected function buildMetadata()
    {
        /* @var $entityTableMetadata \Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata */
        $entityTableMetadata = $this->getEm()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata')->findOneByEntityType($this->getEntityType());
      
        foreach($entityTableMetadata->getAttributes() as $attributeMetadata){

            switch ($attributeMetadata->getType()){
                case "string":
                    $this->metadata[ $attributeMetadata->getName() ] = $this->buildStringMetadataFromAttribute($attributeMetadata);
                    break;
                case "object":                    
                    $this->metadata[ $attributeMetadata->getName() ] = $this->buildObjectMetadataFromAttribute($attributeMetadata);
                    break;
            }
        }        
    }
    
    protected function buildStringMetadataFromAttribute( \Bluegrass\Metadata\Bundle\MetadataBundle\Entity\AttributeMetadata $attributeMetadata )
    {
        return new Metadata( new RawMetadataValueProvider( $this->getMetadataValueFactory() ), $attributeMetadata->getName());
    }

    protected function buildObjectMetadataFromAttribute( \Bluegrass\Metadata\Bundle\MetadataBundle\Entity\AttributeMetadata $attributeMetadata )
    {
        $args = $attributeMetadata->getArgs();
        return new Metadata( new ObjectMetadataValueProvider( $this->getMetadataValueFactory(), $this->getEm(), $args['entityType'] ), $attributeMetadata->getName());
    }
    
    /**
     * 
     * @param string $metadataName
     * @return Bluegrass\Metadata\Bundle\MetadataBundle\Model\Metadata
     * @throws \Exception
     */
    public function getMetadata( $metadataName )
    {
        if(is_null($this->metadata) ){
            $this->buildMetadata();
        }
        
        if( isset($this->metadata[ $metadataName ]) ){
            return $this->metadata[ $metadataName ];    
        }else{
            throw new \Exception("La entidad '" . $this->getEntityType() . "' no tiene definido el metadato '$metadataName'" );
        }
    }    
    
    /**
     * 
     * @return IMetadataValueFactory
     */
    public function getMetadataValueFactory()
    {
        return $this->metadataValueFactory;
    }

    protected function setMetadataValueFactory($metadataValueFactory)
    {
        $this->metadataValueFactory = $metadataValueFactory;
    }    
    
    protected function getEm()
    {
        return $this->em;
    }

    protected function setEm($em)
    {
        $this->em = $em;
    }       
}

<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\AttributeMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\ObjectMetadataValueProvider;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\RawMetadataValueProvider;
use Doctrine\ORM\EntityManager;
use Exception;

/**
 *
 * @author gcaseres
 */
abstract class MetadataProvider implements IMetadataProvider {

    protected $em;
    protected $metadataValueFactory = null;
    protected $metadata = null;

    public function __construct(EntityManager $em) {
        $this->setEm($em);
    }

    protected function getEm() {
        return $this->em;
    }

    protected function setEm($em) {
        $this->em = $em;
    }

    /**
     * 
     * @return IMetadataValueFactory
     */
    public function getMetadataValueFactory() {
        return $this->metadataValueFactory;
    }

    protected function setMetadataValueFactory($metadataValueFactory) {
        $this->metadataValueFactory = $metadataValueFactory;
    }

    /**
     * 
     * @return TableMetadata
     */
    protected abstract function getTableMetadata();

    protected function buildMetadata() {
        $tableMetadata = $this->getTableMetadata();

        foreach ($tableMetadata->getAttributes() as $attributeMetadata) {

            switch ($attributeMetadata->getType()) {
                case "string":
                    $this->metadata[$attributeMetadata->getName()] = $this->buildStringMetadataFromAttribute($attributeMetadata);
                    break;
                case "object":
                    $this->metadata[$attributeMetadata->getName()] = $this->buildObjectMetadataFromAttribute($attributeMetadata);
                    break;
            }
        }
    }

    protected function buildStringMetadataFromAttribute(AttributeMetadata $attributeMetadata) {
        return new Metadata(new RawMetadataValueProvider($this->getMetadataValueFactory()), $attributeMetadata->getName());
    }

    protected function buildObjectMetadataFromAttribute(AttributeMetadata $attributeMetadata) {
        $args = $attributeMetadata->getArgs();
        return new Metadata(new ObjectMetadataValueProvider($this->getMetadataValueFactory(), $this->getEm(), $args['entityType']), $attributeMetadata->getName());
    }

    /**
     * 
     * @param string $metadataName
     * @return Metadata
     * @throws Exception
     */
    public function getMetadata($metadataName) {
        if (is_null($this->metadata)) {
            $this->buildMetadata();
        }

        if (isset($this->metadata[$metadataName])) {
            return $this->metadata[$metadataName];
        } else {
            throw new Exception("El metadato '$metadataName' no está definido.");
        }
    }

}

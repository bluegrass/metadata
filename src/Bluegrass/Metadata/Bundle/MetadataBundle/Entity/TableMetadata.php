<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Entity;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\IMetadataProviderFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="Metadata_TableMetadata")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"logic" = "LogicTableMetadata", "entity" = "EntityTableMetadata"})
 */
abstract class TableMetadata
{
    /** @ORM\Id @ORM\Column(type="integer")  @ORM\GeneratedValue */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="AttributeMetadata", mappedBy="owner", cascade={"persist"})
     **/
    protected $attributes;

    public function __construct() {
        $this->attributes = new ArrayCollection();
    }    
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @return AttributeMetadata[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }    
    
    public function addAttribute(AttributeMetadata $attribute)
    {
        $attribute->setOwner($this);
        $this->attributes[] = $attribute;
    }
            
    public abstract function getMetadataProviderFromFactory(IMetadataProviderFactory $providerFactory);
}


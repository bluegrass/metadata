<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Representa el model de la especificación de un metadato
 *
 * @author ldelia
 * @ORM\Entity
 * @ORM\Table(name="Metadata_AttributeMetadata")
 */
class AttributeMetadata
{
    /** @ORM\Id @ORM\Column(type="integer")  @ORM\GeneratedValue */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="TableMetadata", inversedBy="attributes")
     **/
    protected $owner;
    
    /** @ORM\Column(type="string") */    
    protected $name;
    
    /** @ORM\Column(type="string") */    
    protected $type;
   
    /** @ORM\Column(type="array", nullable=true) */    
    protected $args;
    
    public function __construct( $name, $type, $args = array() )
    {
        $this->setName($name);
        $this->setType($type);
        $this->setArgs($args);
    }
    
    public function getOwner()
    {
        return $this->owner;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getArgs()
    {
        return $this->args;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setArgs($args)
    {
        $this->args = $args;
    }    
}


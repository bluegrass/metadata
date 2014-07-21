<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @author ldelia
 * @ORM\Entity
 */
class LogicTableMetadata extends TableMetadata
{
    /** @ORM\Column(type="string") */    
    protected $name;
    
    public function __construct( $name )
    {
        parent::__construct();
        $this->setName($name);
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }    
}


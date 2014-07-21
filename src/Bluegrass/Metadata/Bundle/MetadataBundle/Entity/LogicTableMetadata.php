<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Entity;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory\IMetadataProviderFactory;
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
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }    
    
    /**
     * 
     * {@inheritdoc }
     */
    public function getMetadataProviderFromFactory(IMetadataProviderFactory $providerFactory) {
        return $providerFactory->getProviderForLogicTable($this);
    }            
}


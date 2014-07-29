<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Doctrine\ORM\EntityManager;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\LogicTableMetadataProvider;
use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataValueProvider\Factory\IMetadataValueFactory;

/**
 * Factory para LogicTableMetadataProvider.
 * 
 * Esta factory implementa IConcreteMetadataProviderFactory para facilitar
 * la generación de instancias de LogicTableMetadataProvider a partir de un
 * IMetadataProviderFactory.
 *
 * @author gcaseres
 */
class LogicTableMetadataProviderFactory implements IConcreteMetadataProviderFactory {
    
    protected $em;
    protected $tableName;    
    protected $metadataValueFactory;
    
    public function __construct(EntityManager $em, $tableName, IMetadataValueFactory $metadataValueFactory) 
    {
        $this->em = $em;
        $this->tableName = $tableName;
        $this->metadataValueFactory = $metadataValueFactory;
    }
    
    public function create() 
    {
        return new LogicTableMetadataProvider($this->em, $this->tableName, $this->metadataValueFactory);
    }

}

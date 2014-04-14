<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\Factory;

use Doctrine\ORM\EntityManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider;

/**
 * Genera instancias de MetadataProvider según una instancia concreta
 *
 * @author ldelia
 */
class MetadataProviderFactory implements IMetadataProviderFactory
{
    protected $metadataProviders;
    
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    /**
     * 
     * @param type $metadataEntityClassName
     * @return \Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\IMetadataProvider
     */
    public function getProviderFor( $metadataEntityClassName )
    {
        if( isset( $this->metadataProviders[ $metadataEntityClassName ] ) ){
            
            /*
             * todo: revisar que no siempre los MetadataProvider van a depender del EM. En particular los provider basados en EntityTableMetadatos si lo van a necesitar. Refactorizar
             */            
            $metadataProvider = $this->metadataProviders[ $metadataEntityClassName ];
            return new $metadataProvider( $this->em );            
            
        }else{
            throw new \Exception("No se encuentra definido un Metadata Provider para la entidad " . $metadataEntityClassName);
        }               
    }
    
    public function setProvider( $metadataEntityClassName, $metadataProviderClassName )
    {
        $this->metadataProviders[ $metadataEntityClassName ] = $metadataProviderClassName;
    }
}


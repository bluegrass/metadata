<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model;

/**
 * Las clases que implementen está clase tendrán la capacidad de manipular metadatos
 * @author ldelia
 */
interface IMetadataEntity
{
    
    /**
     * Obtiene el valor asociado a un metadato de la entidad
     * @param \Pronit\Metadata\Model\Metadata $metadata
     * @return \Pronit\Metadata\Model\IMetadataValue
     * @throws \Exception
     */
    public function getMetadata( Metadata $metadata );
            
    /**
     * Agrega el valor asociado a un metadato de la entidad
     * @param \Pronit\Metadata\Model\Metadata $metadata
     * @param type $value
     */
    public function setMetadata( Metadata $metadata, $value );
}

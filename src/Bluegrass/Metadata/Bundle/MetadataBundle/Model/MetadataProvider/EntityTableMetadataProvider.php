<?php

use Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider\MetadataProvider;

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\MetadataProvider;

/**
 * Provee metadatos para una entidad.
 *
 * @author ldelia
 */
abstract class EntityTableMetadataProvider extends MetadataProvider {

    protected function getTableMetadata() {
        $entityTableMetadata = $this->getEm()->getRepository('\Bluegrass\Metadata\Bundle\MetadataBundle\Entity\EntityTableMetadata')->findOneByEntityType($this->getEntityType());

        if (is_null($entityTableMetadata)) {
            throw new Exception('No se encontró la estructura de metadatos asociada a la entidad ' . $this->getEntityType());
        }

        return $entityTableMetadata;
    }

}

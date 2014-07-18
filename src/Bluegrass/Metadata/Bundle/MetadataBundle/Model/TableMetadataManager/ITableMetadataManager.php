<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Model\TableMetadataManager;

use Bluegrass\Metadata\Bundle\MetadataBundle\Entity\TableMetadata;

/**
 *
 * @author gcaseres
 */
interface ITableMetadataManager {
    function persistTableMetadata(TableMetadata $tableMetadata);
    function deleteTableMetadata(TableMetadata $tableMetadata);
}

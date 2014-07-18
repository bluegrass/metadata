<?php

namespace Bluegrass\Metadata\Bundle\MetadataBundle\Tests\Utils;

/**
 * Esta clase se define para simular una entidad del dominio mapeada al ORM.
 * 
 * Se hace necesario definir esta clase debido a que algunos objetos del modelo
 * de metadatos asumen que las entidades tiempre tienen un método getId() para
 * obtener la clave primaria.
 *
 * @author gcaseres
 */
class EntityMock {
    
    public function getId() {
        
    }
}

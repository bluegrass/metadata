# Bluegrass :: MetadataBundle

Bluegrass::Metadata es un Bundle de Symfony2 orientado al manejo de entidades con atributos dinámicos sobre Doctrine2. 

Estos atributos dinámicos pueden persitirse junto al resto de la entidad de manera transparente.

La idea de atributos dinámicos proviene de la necesidad de permitir al usuario de un sistema agregar información adicional a las entidades de su dominio con las que trabaja.

Por ejemplo, de acuerdo al uso que le da un usuario a su sistema, el mismo podría necesitar un atributo adicional "Gobernador" en su lista de "Paises", mientras que otros usuarios podrían no necesitarlo o incluso necesitar otros atributos.

De esta manera, se propone un mecanismo que permite adosar nuevos atributos a las entidades existentes en el sistema de manera dinámica, sin alterar las estructuras ya definidas para el funcionamiento del dominio.

Bluegrass::Metadata provee una plataforma para la solución de estas necesidades de facil integración con Doctrine2.


## Conceptos generales

MetadataBundle presenta un modelo de metadatos que permite la definición de atributos dinámicos para entidades existentes.

El modelo de metadatos está formado por las siguientes componentes:

### Modelo de manejo de metadatos

El uso de atributos dinámicos en una entidad implica que los setters/getters asociados a la misma no existen. Por este motivo el mecanismo de acceso a estos atributos difiere del mecanismo tradicional.

Cuando se desea permitir que una entidad del dominio contenga atributos dinámicos, es necesario implementar la interfaz IMetadataEntity.

Esta interfaz declara dos métodos:
 * `IMetadataEntity::getMetadata(Metadata $metadata)`
 * `IMetadataEntity::setMetadata(Metadata $metadata, $value)`

A través de esos dos métodos, el usuario de la entidad con atributos dinámicos puede asignar u obtener los valores almacenados en dichos atributos.

La clase Metadata, representa un atributo dinámico de una entidad en particular. No representa la definición/declaración del metadato, sino que "es" el atributo en particular.

Por este motivo, obtener el valor de un metadato, solo implica invocar al método getMetadata de la instancia de la entidad con la que estamos trabajando con la instancia de Metadata (atributo) del cual deseamos obtener su valor.


En la práctica, un ejemplo en concreto es el siguiente:

    $gobernador = $pais->getMetadata($gobernadorMetadata); //Obtiene el valor del atributo dinámico "gobernador" de la instancia de la clase Pais.
    $gobernador = new Gobernador('Nuevo gobernador'); //Instancia un nuevo gobernador.
    $pais->setMetadata($gobernadorMetadata, $gobernador); //Asigna el nuevo gobernador como valor del atributo dinámico "gobernador" de la instancia de la clase Pais.
    $em->persist($pais); //Se persiste la entidad junto con todos sus valores de atributos dinámicos asociados.
    
Se puede observar que el código de ejemplo muestra la manera de trabajar sobre una `IMetadataEntity` a partir de una instancia de `Metadata` correctamente inicializada.

### Persistencia de atributos dinámicos

En primer lugar, para que una entidad pueda contener atributos dinámicos persistibles, es necesario que la misma implemente la interfaz `IMetadataEntity`.

Una implementación tradicional es la siguiente:

    class Pais : IMetadataEntity {
      /**
       * @ORM\OneToMany(targetEntity="PaisMetadataValue", mappedBy="pais", cascade={"ALL"}, indexBy="metadataName",  orphanRemoval=true)
       */
      private $metadataValues;      
    
      public function __construct() {
        $this->metadataValues = new \Doctrine\Common\Collections\ArrayCollection();
      }
    
      public function getMetadata(Metadata $metadata) {
        return $metadata->getValue($this->metadataValues[$metadata->getName()]);
      }
      
      public function setMetadata(Metadata $metadata, $value) {
        $metadataValue = $metadata->createValue($this, $value);
        $this->metadataValues[$metadata->getName()] = $metadataValue;        
      }
    }

Notar que esta implementación asume la existencia de una entidad "PaisMetadataValue". También es importante notar que los "metadataValues" están indexados en un arreglo asociativo a partir de un "metadataName" (directiva indexBy del ORM annotation).

Esta definición tradicional de una entidad con atributos dinámicos, define un arreglo indexado de "MetadataValue".

Un "MetadataValue" es un contenedor de valores de atributos dinámicos.

El modelo de metadatos define la interfaz `IMetadataValue`, la cual declara el método `getValue()` y funciona como contenedor de valores homogéneo para todo el modelo de metadatos.

Persistir los valores de los atributos dinámicos asociados a una entidad dinámica, implica declarar una nueva clase que implemente `IMetadataValue`. Dado que se desea persistir la información contenida en este contenedor, es necesario que esta nueva clase sea una entidad de Doctrine.


Una implementación tradicional de `IMetadataValue` es la siguiente:

    /** 
     * @ORM\Entity
     */
    class PaisMetadataValue : IMetadataValue {
    
      /** @ORM\Column(type="string") */
      private $value;
      
      /** @ORM\Column(type="string") */
      private $metadataName;

      /** @ORM\ManyToOne(targetEntity="Pais") */
      private $pais;
      
      public function __construct(Pais $pais, $metadataValue, $value) {
        $this->pais = $pais;
        $this->metadataValue = $metadataValue;
        $this->value = $value;
      }
    
      public function getValue()
      {
          return $this->value;
      }

      public function getPais()
      {
          return $this->pais;
      }

      public function getMetadataName()
      {
          return $this->metadataName;
      }

    }

Se puede observar que `PaisMetadataValue` define un contenedor de valores con una referencia a la entidad "dueña" de estos valores.

El atributo `$value` se mapea como string, asumiendo que cualquier tipo de valor que se quiera almacenar en el contenedor podrá ser serializado a un string.

Notar que también se define un atributo `$metadataName` que permite identificar a qué atributo dinámico corresponde el valor que se está conteniendo. Es por este motivo que la entidad dinámica indexa su lista de "MetadataValue" a partir del `metadataName`.


Por último, necesitamos definir una clase que sea capaz de instanciar nuestro "MetadataValue". Esta clase funcionará como factory de nuestros "MetadataValue" y deberá implementar `IMetadataValueFactory`

    class PaisMetadataValueFactory : IMetadataValueFactory {
      public function createMetadataValue(IMetadataEntity $entity, $metadataName, $value) {
        return new PaisMetadataValue($entity, $metadataValue, $value);
      }
    }


Con la definición de la entidad dinámica (Pais) y de su contenedor de valores de atributos dinámicos (PaisMetadataValue), ya estamos en condiciones de asociar atributos dinámicos a un Pais y persistirlos.

A modo de ejemplo simple, se muestra la utilización de atributos dinámicos de tipo "string":

    $paisMetadataValueFactory = new PaisMetadataValueFactory();
    
    $pais = new Pais();
    $metadata = new Metadata("reseña_historica", new RawMetadataValueProvider($paisMetadataValueFactory));
    $pais->setMetadata($metadata, "Constituido en 1679");
    
    $metadata = new Metadata("codigo_iso", new RawMetadataValueProvider($paisMetadataValueFactory));
    $pais->setMetadata($metadata, "AR");
    
    $em->persist($pais);
    
    $pais = $paisesRepository->find(1);
    
    $metadata = new Metadata("reseña_historica", new RawMetadataValueProvider($paisMetadataValueFactory));
    $resena_historica = $pais->getMetadata($metadata);
    
    $metadata = new Metadata("codigo_iso", new RawMetadataValueProvider($paisMetadataValueFactory));
    $codigo_iso = $pais->getMetadata($metadata);
    

Se puede observar que en este caso, dado que se están persistiendo atributos dinámicos de tipo "string" (raw), se utilizó una instancia de `RawMetadataValueProvider`, que es una implementación de `IMetadataValueProvider`.

Una implementación de `IMetadataValueProvider` es una clase encargada de interpretar el valor almacenado en un "MetadataValue".

Cuando se trata de un "string", el valor generalmente no requiere ningún tipo de procesamiento, ya que el mismo se persiste tal como está en la base de datos. Sin embargo, si el valor a almacenar requiere algún tipo de procesamiento (por ejemplo, serialización), el "MetadataValueProvider" será el encargado de realizarla.

A efectos prácticos, el "MetadataValueProvider" determina el tipo de datos asociado al atributo dinámico.

Se puede observar entonces que instanciar un "Metadata" implica conocer dos elementos fundamentaes para un atributo dinámico:
 * Nombre del atributo ($name).
 * Tipo del atributo ($metadataValueProvider)


En la siguiente sección se muestra como definir plantillas o estructuras de metadatos que permiten especificar cuáles son los atributos dinámicos con los que puede trabajar una entidad dinámica.


### Modelo de declaración de metadatos

En la sección anterior se mostró que es posible asignar nuevos atributos a una entidad en tiempo de ejecución. Estos atributos pueden ser persistidos a través de Doctrine y sus valores pueden ser obtenidos en otro momento.

Sin embargo, en la mayoría de los casos se vuelve necesario predefinir las estructuras dinámicas, haciéndolas semi-dinámicas. Es decir, el usuario del sistema pre-define cuáles son los atributos dinámicos (y sus tipos de datos) para cada entidad dinámica, y luego los utiliza, sin necesidad de definir nuevos mappings ORM o de modificar clases estáticas existentes.

Definir las estructuras de esta manera, facilita la obtención de los "Metadata" específicos, dado que no es necesario conocer mas que el nombre del "Metadata" (nombre del atributo dinámico) para obtener/modificar su valor sobre una entidad dinámica.

MetadataBundle define a tales efectos una serie de entidades persistibles con el objetivo de representar las características de los atributos dinámicos asociados a las entidades del dominio.

Las dos entidades mas importantes para definir la estructura de metadatos son:
 * `AttributeMetadata`: Define las características de un atributo dinámico.
 * `EntityTableMetadata`: Agrupador de `AttributeMetadata`, se relaciona con una entidad persistible del sistema y representa su parte dinámica.
 


Hasta ahora vimos que instanciar un `Metadata` no es sencillo. El constructor de `Metadata` requiere dos parámetros:
 * `IMetadataValueProvider $provider`: Proveedor de contenedores de valores de metadatos. 
 * `$name`: Identificador del metadato.

Una instancia de `Metadata` representa un "manejador" del valor asociado a un atributo dinámico en una instancia de una entidad en particular.

Por ejemplo, si se desea que la entidad "Pais" tenga un atributo dinámico "Gobernador", necesitamos trabajar entonces con un `Metadata` de nombre "Gobernador".

Sin embargo, no alcanza solo con conocer el nombre del atributo dinámico con el que deseamos trabajar, sino que también necesitamos especificar qué tipo de datos va a contener ese atributo y cómo acceder a los valores de ese tipo.

La implementación de `IMetadataValueProvider` es la encargada de conocer la estrategia relacionada con obtener o generar el valor de un metadato. Define dos métodos:
 * `createValue( IMetadataEntity $entity, Metadata $metadata, $value )`
 * `getValue( IMetadataValue $metadataValue )`

Ambos métodos devuelven un `IMetadataValue` que es un contenedor del valor de un atributo dinámico.

La implementación mas simple de `IMetadataValueProvider` es `RawMetadataValueProvider` 

 

 * MetadataValue: Representa un contenedor de un valor almacenado en un atributo dinámico. Para obtener el valor contenido o construir un contenedor con un valor, es necesario utilizar un "Metadata".
 * MetadataValueProvider: Todo "Metadata" está asociado a un "MetadataValueProvider". Los "Metadata" siempre están asociados a una especialización de "MetadataValueProvider" para poder llevar a cabo la operación de crear un "MetadataValue" o devolver el valor contenido en un "MetadataValue".





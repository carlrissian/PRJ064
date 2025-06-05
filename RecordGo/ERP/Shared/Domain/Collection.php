<?php


namespace Shared\Domain;


use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Shared\Domain\Exception\NotFoundInCollectionException;

/**
 * Class Collection
 * @package Shared\Domain
 */
abstract class Collection implements IteratorAggregate, Countable, ArrayAccess
{
    /** @var array */
    protected $items;

    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        Assert::arrayOf($this->type(), $items);
        $this->items = array_values($items);
    }

    /**
     * @return string
     */
    abstract protected function type(): string;

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    public function count()
    {
        return count($this->items);
    }

    /**
     * @param object $item
     */
    public function add(object $item): void
    {
        Assert::arrayOf($this->type(), [$item]);
        $this->items = array_merge($this->items, [$item]);
    }

    /**
     * Función que devuelve un Elemento de la colección según valor de propiedad.
     * Se le pasa el valor a comparar y un string o array de strings como propiedades.
     * Si se le pasa String devuelve el Elemento que cumpla $needle = getPorperty()
     * Si se le pasa Array de string devuelve el Elemento que cumpla $needlee = getProperty[0]()->getProperty[1]()->getProperty[2]()...
     * @param $needle
     * @param mixed $properties
     * @return mixed
     * @throws NotFoundInCollectionException
     */
    public function getByProperty($needle, $properties = "Id")
    {
        $neededObject = array_filter(
            $this->toArray(),
            function ($e) use ($needle, $properties) {
                if(is_array($properties)){
                    $propertyAux = $e;
                    foreach ($properties as $property){
                        $propertyAux = $propertyAux->{"get".$property}();
                    }
                    return $propertyAux == $needle;
                }else
                    return $e->{"get".$properties}() == $needle;
            }
        );

        if(empty($neededObject)) {
            throw new NotFoundInCollectionException();
        }

        return reset($neededObject);
    }

    /**
     * Función que reemplaza un Elemento según Objeto
     * Se le pasa el Elemento a reemplazar y el nuevo Elemento
     * @param object $old
     * @param object $new
     */
    public function replaceItem(object $old, object $new): void
    {
        Assert::arrayOf($this->type(), [$old, $new]);
        $this->items = array_map(
            function ($e) use ($old, $new) {
                if($e==$old)
                    return $new;
                else
                    return $e;
            },
            $this->toArray()
        );
    }

    /**
     * Función que elimina un Elemento según Objeto de la clase de la colección
     * Se le pasa el Elemento a reemplazar y el nuevo Elemento
     * @param object $objectToRemove
     */
    public function removeByObject(object $objectToRemove): void
    {
        Assert::arrayOf($this->type(), [$objectToRemove]);
        $this->items = array_values(
            array_filter($this->toArray(),
            function ($e) use ($objectToRemove) {
                return $e != $objectToRemove;
            }
        ));
    }

    /**
     * Función que elimina uno o varios Elemento de la colección según valor de propiedad.
     * Se le pasa el valor a comparar y un string o array de strings como propiedades.
     * Si se le pasa String elimina el Elemento que cumpla $needle = getPorperty()
     * Si se le pasa Array de string elimina el/los Elemento/s que cumpla $needlee = getProperty[0]()->getProperty[1]()->getProperty[2]()...
     * @param $needle
     * @param mixed $property
     */
    public function removeByProperty($needle, $properties = "Id"): void
    {
        $this->items = array_values(
            array_filter($this->toArray(),
                function ($e) use ($needle, $properties) {
                    if(is_array($properties)){
                        $propertyAux = $e;
                        foreach ($properties as $property){
                            $propertyAux = $propertyAux->{"get".$property}();
                        }
                        return $propertyAux != $needle;
                    }else
                        return $e->{"get".$properties}() != $needle;
                }
        ));
    }
}

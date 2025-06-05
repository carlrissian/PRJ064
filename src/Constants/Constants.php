<?php


namespace App\Constants;


class Constants
{

    protected $constants;
    protected $constantKeys;

    /**
     * Por reflection obtengo la lista de constantes de la clase y las
     * agrega a un array privado a nivel del objeto al momento de instanciarse el objeto
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $class = new \ReflectionClass(get_class($this));
        $this->constants = $class->getConstants();
        $this->constantKeys = array_keys($this->constants);
    }

    /**
     * Al momento de invocarse a la constante, PHP interpreta que debería ser una
     * propiedad pública del objeto y como efectivamente no existe, se llama al método
     * __isset para que nosotros decidamos si existe o no. Lo que hacemos es fijarnos
     * si el nombre de la constante que es invocada existe dentro de nuestro array de
     * constantes descubiertas por reflection
     */
    public function __isset($name)
    {
        if (in_array($name, $this->constantKeys)) {
            return true;
        }

        return false;
    }

    /**
     * Cuando el método __isset devuelve true, entra al método __get y devuelve
     * el valor de la constante
     */
    public function __get($name)
    {
        if (in_array($name, $this->constantKeys)) {
            return $this->constants[$name];
        }

        return null;
    }

}
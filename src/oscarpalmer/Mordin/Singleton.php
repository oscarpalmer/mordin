<?php

namespace oscarpalmer\Mordin;

/**
 * A Singleton class for purely static classes;
 * e.g. a global configuration class.
 */
class Singleton
{
    /**
     * @var array Array of Singleton class instances.
     */
    protected static $instances = array();

    // Ignore unused methods.
    //
    // @codeCoverageIgnoreStart

    private function __construct()
    {
        /** Private constructor to prevent initialization from the outside. */
    }

    private function __clone()
    {
        /** Prevents cloning of instances. */
    }

    private function __wakeup()
    {
        /** Prevents unserializing of instances. */
    }

    // @codeCoverageIgnoreEnd

    /**
     * Retrieve the class instance.
     *
     * @return Singleton Class instance.
     */
    public static function getInstance()
    {
        $name = get_called_class();

        if (array_key_exists($name, static::$instances) === false) {
            static::$instances[$name] = new static;
        }

        return static::$instances[$name];
    }
}

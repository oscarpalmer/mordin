<?php

namespace oscarpalmer\Mordin;

/**
 * A Singleton class for purely static classes;
 * e.g. a global configuration class.
 */
class Singleton
{
    /**
     * Protected constructor to prevent
     * initialization from the outside.
     */
    protected function __construct(){}

    /**
     * Prevents cloning of instances.
     */
    private function __clone(){}

    /**
     * Prevents unserializing of instances.
     */
    private function __wakeup(){}

    /** Static functions. */

    /**
     * Retrieve the class instance.
     *
     * @return Singleton Class instance.
     */
    public static function getInstance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new static;
        }

        return $instance;
    }
}
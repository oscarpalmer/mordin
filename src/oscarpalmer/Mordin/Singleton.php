<?php

namespace oscarpalmer\Mordin;

/**
 * A Singleton class for purely static classes;
 * e.g. a global configuration class.
 */
class Singleton
{
    protected function __construct()
    {
        /** Protected constructor to prevent initialization from the outside. */
    }

    private function __clone()
    {
        /** Prevents cloning of instances. */
    }

    private function __wakeup()
    {
        /** Prevents unserializing of instances. */
    }

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

<?php

namespace oscarpalmer\Mordin;

class Arr
{
    /**
     * Get first element of array.
     *
     * @param  array $array Array to search.
     * @return mixed First element.
     */
    public static function first(array $array)
    {
        if (empty($array) === false) {
            return array_shift($array);
        }

        throw new \LogicException("The supplied array is empty.");
    }

    /**
     * Get value of element from array or default if not found.
     *
     * @param  array      $array   Array to search.
     * @param  int|string $key     Key for element.
     * @param  mixed      $default Default value.
     * @return mixed Value for element or default value.
     */
    public static function get(array $array, $key, $default = null)
    {
        if (is_int($key) || is_string($key)) {
            if (array_key_exists($key, $array)) {
                return $array[$key];
            }

            return $default;
        }

        $prefix = "Key must be of type \"integer\" or \"string\", \"";

        throw new \InvalidArgumentException($prefix . gettype($key) . "\" given.");
    }

    /**
     * Convert array to JSON.
     *
     * @param  array  $array Array to convert.
     * @return string Array as JSON.
     */
    public static function json(array $array)
    {
        return json_encode($array);
    }

    /**
     * Get last element of Array.
     *
     * @param  array Array to search.
     * @return mixed Last element.
     */
    public static function last(array $array)
    {
        if (empty($array) === false) {
            return array_pop($array);
        }

        throw new \LogicException("The supplied array is empty.");
    }

    /**
     * Merge one array with another.
     *
     * @param  array  $to       Destination array.
     * @param  array  $from     Departure array.
     * @param  bool   $override True to override destination keys.
     * @return array Merged array.
     */
    public static function merge(array $to, array $from, $override = false)
    {
        if (is_bool($override)) {
            foreach ($from as $key => $value) {
                if (array_key_exists($key, $to) && $override === false) {
                    continue;
                }

                $to[$key] = $value;
            }

            return $to;
        }

        $prefix = "Override value must be of type \"boolean\", \"";

        throw new \InvalidArgumentException($prefix . gettype($override) . "\" given.");
    }
}

<?php

namespace oscarpalmer\Mordin;

class Arr
{
    /**
     * Get first element of array.
     *
     * @param  array $array Array to search.
     * @return mixed First element or false.
     */
    public static function first(array $array)
    {
        if (empty($array) === false) {
            return array_shift($array);
        }

        return false;
    }

    /**
     * Get value of element from array or default if not found.
     *
     * @param  array      $array   Array to search.
     * @param  int|string $key     Key for element.
     * @param  mixed      $default Default value.
     * @return mixed      Value for element or a default value.
     */
    public static function get(array $array, $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
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
     * @return mixed Last element or false.
     */
    public static function last(array $array)
    {
        if (empty($array) === false) {
            return array_pop($array);
        }

        return false;
    }

    /**
     * Merge one array with another.
     *
     * @param  array $to       Destination array.
     * @param  array $from     Departure array.
     * @param  bool  $override True to override destination keys.
     * @return array Merged array or false.
     */
    public static function merge(array $to, array $from, $override = false)
    {
        foreach ($from as $key => $value) {
            if (array_key_exists($key, $to) && $override !== true) {
                continue;
            }

            $to[$key] = $value;
        }

        return $to;
    }
}

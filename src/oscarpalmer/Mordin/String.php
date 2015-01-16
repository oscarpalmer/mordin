<?php

namespace oscarpalmer\Mordin;

class String
{
    /**
     * Check if a string begins with a substring.
     *
     * @param  string $string    String to search.
     * @param  string $substring Substring to search for.
     * @return bool   True if found.
     */
    public static function beginsWith($string, $substring, $insensitive = false)
    {
        if ($insensitive === true) {
            $string = static::lowercase($string);
            $substring = static::lowercase($substring);
        }

        return static::substring($string, 0, static::length($substring)) === $substring;
    }

    /**
     * Check if a string contains a substring.
     *
     * @param  string $string    String to search.
     * @param  string $substring Substring to search for.
     * @return bool   True if found.
     */
    public static function contains($string, $substring, $insensitive = false)
    {
        $method = $insensitive === true ? "mb_stristr" : "mb_strstr";

        return $method($string, $substring, false, "utf-8") !== false;
    }

    /**
     * Check if a string ends with a substring.
     *
     * @param  string $string    String to search.
     * @param  string $substring Substring to search for.
     * @return bool   True if found.
     */
    public static function endsWith($string, $substring, $insensitive = false)
    {
        if ($insensitive === true) {
            $string = static::lowercase($string);
            $substring = static::lowercase($substring);
        }

        return static::substring($string, -static::length($substring)) === $substring;
    }

    /**
     * Excerpt a long string.
     *
     * @param  string $string      String to excerpt.
     * @param  int    $limit       Character limit for excerpt.
     * @param  string $punctuation Punctuation for excerpt.
     * @return string Excerpted string.
     */
    public static function excerpt($string, $limit = 140, $punctuation = "…")
    {
        if ($limit >= static::length($string)) {
            return $string;
        }

        $limit = $limit - static::length($punctuation);

        return static::substring($string, 0, $limit) . $punctuation;
    }

    /**
     * Check if string is a valid email address.
     *
     * @param  string $string String to validate.
     * @return bool   True if valid.
     */
    public static function isEmail($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Check if string is a valid URL.
     *
     * @param  string $string String to validate.
     * @return bool   True if valid.
     */
    public static function isUrl($string)
    {
        return filter_var($string, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * UTF-8 compliant strlen replacement.
     *
     * @param  string $string String to measure.
     * @return int    String length.
     */
    public static function length($string)
    {
        return mb_strlen($string, "utf-8");
    }

    /**
     * UTF-8 compliant strtolower replacement.
     *
     * @param  string $string String to convert.
     * @return string Lowercase string.
     */
    public static function lowercase($string)
    {
        return mb_strtolower($string, "utf-8");
    }

    /**
     * UTF-8 compliant substr replacement.
     *
     * @param  string $string String to search.
     * @param  int    $offset Offset start position.
     * @param  int    $length Length of substring.
     * @return string Substring.
     */
    public static function substring($string, $offset, $length = null)
    {
        return mb_substr($string, $offset, $length ?: static::length($string), "utf-8");
    }

    /**
     * UTF-8 compliant strtoupper replacement.
     *
     * @param  string $string String to convert.
     * @return string Uppercase string.
     */
    public static function uppercase($string)
    {
        return mb_strtoupper($string, "utf-8");
    }

    /**
     * Ensures that there are no typographical widows.
     * Returns the string if it consist of only three words.
     *
     * @param  string $string String to "unwidow".
     * @return string Widowless string.
     */
    public static function widont($string)
    {
        if (static::words($string, true) < 4) {
            return $string;
        }

        return preg_replace_callback("/\A(.+)\s+(.+)\z/", function ($matches) {
            return "{$matches[1]}&nbsp;{$matches[2]}";
        }, trim($string));
    }

    /**
     * Get an array of or count the words in a string.
     * Words are only separated by spaces,
     * and keep their nearest punctuations.
     *
     * @param  string $string String to count.
     * @param  bool   $count  Count the number of words?
     * @return array|integer  Array of words or amount of words.
     */
    public static function words($string, $count = false)
    {
        $words = preg_split("/\s+/", $string);

        return $count === true ? count($words) : $words;
    }
}

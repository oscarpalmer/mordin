<?php

namespace oscarpalmer\Mordin;

class File
{
    /**
     * Create an empty file.
     *
     * @param  string $file File to create.
     * @return bool   True for success.
     */
    public static function create($file)
    {
        if (is_string($file)) {
            return self::write($file, "");
        }

        return false;
    }

    /**
     * Delete a file.
     *
     * @param  string $file File to delete.
     * @return bool   True for success.
     */
    public static function delete($file)
    {
        if (self::isFile($file)) {
            return unlink($file);
        }

        return false;
    }

    /**
     * Check if it's a file.
     *
     * @param  mixed $file Variable to check.
     * @return bool  True if... well, if it's true.
     */
    public static function isFile($file)
    {
        return is_string($file) && is_file($file);
    }

    /**
     * Read a file.
     *
     * @param  string $file File to read.
     * @return mixed  Contents of file or false if it could not be read.
     */
    public static function read($file)
    {
        if (self::isFile($file)) {
            return file_get_contents($file);
        }

        return false;
    }

    /**
     * Rename a file.
     *
     * @param  string $old Old filename.
     * @param  string $new New filename.
     * @return bool   True for success.
     */
    public static function rename($old, $new)
    {
        if (self::isFile($old) && is_string($new)) {
            return rename($old, $new);
        }

        return false;
    }

    /**
     * Write data to a file.
     *
     * @param  string $file File to write to.
     * @param  mixed  $data Data to write. Arrays and objects are JSON'd.
     * @return bool   True for success.
     */
    public static function write($file, $data)
    {
        if (is_string($file)) {
            if (is_array($data) || is_object($data)) {
                $data = json_encode($data);
            }

            return file_put_contents($file, (string) $data, LOCK_EX) === false ? false : true;
        }

        return false;
    }
}

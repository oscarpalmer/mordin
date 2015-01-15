<?php

namespace oscarpalmer\Mordin;

class File
{
    /**
     * Create an empty file.
     *
     * @param  string $file File to create.
     * @param  mixed  $data Optional data to write.
     * @return bool   True for success.
     */
    public static function create($file, $data = "")
    {
        if (is_file($file) === false) {
            return self::write($file, $data);
        }

        return false;
    }

    /**
     * Delete a file or directory.
     *
     * @param  string $file File or directory to delete.
     * @return bool   True for success.
     */
    public static function delete($file)
    {
        if (self::exists($file)) {
            if (is_file($file)) {
                return unlink($file);
            }

            return rmdir($file);
        }

        return false;
    }

    /**
     * Check if a file or directory exists.
     *
     * @param  mixed $item Variable to check.
     * @return bool  True if the file or directory exists.
     */
    public static function exists($item)
    {
        return is_string($item) && file_exists($item);
    }

    /**
     * Create a directory, either flat or recursively.
     *
     * @param  string $directory   Directory name.
     * @param  mixed  $permissions Permissions for directory.
     * @param  bool   $recursive   True for recursive directory creation.
     * @return bool   True for success.
     */
    public static function mkdir($directory, $permissions = 0777, $recursive = true)
    {
        if (is_bool($permissions)) {
            $recursive = $permissions;
            $permissions = 0777;
        }

        if (is_dir($directory) === false) {
            return mkdir($directory, $permissions, $recursive);
        }

        return false;
    }

    /**
     * Read a file.
     *
     * @param  string $file File to read.
     * @return mixed  Contents of file or false if it could not be read.
     */
    public static function read($file)
    {
        if (self::exists($file) && is_file($file)) {
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
        if (self::exists($old) && self::exists($new) === false) {
            return rename($old, $new);
        }

        return false;
    }

    /**
     * Get the size of a file.
     *
     * @todo Parse file size into human readable format.
     * @todo Weigh directories?
     *
     * @param string $file Filename to weigh.
     * @return int   Filesize as an integer or false.
     */
    public static function size($file)
    {
        if (self::exists($file) && is_file($file)) {
            return filesize($file);
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
        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
        }

        return @file_put_contents($file, (string) $data, LOCK_EX) === false ? false : true;
    }
}

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
        if (is_string($file) && is_file($file) === false) {
            return self::write($file, $data);
        }

        if (is_string($file) === false) {
            throw new \InvalidArgumentException("Filename must be a string, " . gettype($file) . " given.");
        }

        throw new \LogicException("\"{$file}\" could not be created as it already exists.");
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

        if (is_string($file) === false) {
            throw new \InvalidArgumentException("Filename must be a string, " . gettype($file) . " given.");
        }

        throw new \LogicException("{$file} could not be deleted as it does not exist.");
    }

    /**
     * Check if a file or directory exists.
     *
     * @param  mixed $item Variable to check.
     * @return bool  True if it's a filename and the file or directory exists.
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

        if (is_string($directory) && is_numeric($permissions) && is_bool($recursive)) {
            if (is_dir($directory) === false) {
                return mkdir($directory, $permissions, $recursive);
            }

            throw new \LogicException("\"{$directory}\" could not be created as it already exists.");
        }

        if (is_string($directory) === false) {
            throw new \InvalidArgumentException("Directory name must be a string, " . gettype($directory) . " given.");
        } elseif (is_numeric($permissions) === false) {
            throw new \InvalidArgumentException("Permissions must be numeric, " . gettype($permissions) . " given.");
        }

        throw new \InvalidArgumentException("Recursive value must be a boolean, " . gettype($recursive) . " given.");
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

        throw new \LogicException("The file \"{$file}\" does not exist.");
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
        if (self::exists($old) && is_string($new)) {
            return rename($old, $new);
        }

        if (is_string($old) === false) {
            throw new \InvalidArgumentException("The old filename must be a string, " . gettype($old) . " given.");
        } else if (is_file($old) === false) {
            throw new \LogicException("The file \"{$old}\" does not exist.");
        }

        throw new \InvalidArgumentException("The new filename must be a string, " . gettype($new) . " given.");
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

            return @file_put_contents($file, (string) $data, LOCK_EX) === false ? false : true;
        }

        throw new \InvalidArgumentException("Filename must be a string, " . gettype($file) . " given.");
    }
}

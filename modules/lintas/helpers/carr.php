<?php
namespace Lintas\helpers;
use Illuminate\Support\Arr;

class carr extends Arr {
    public static function extract($array, array $paths, $default = NULL) {
        $found = array();
        foreach ($paths as $path) {
            carr::set_path($found, $path, carr::path($array, $path, $default));
        }

        return $found;
    }

    public static function set_path(& $array, $path, $value, $delimiter = NULL) {
        if (!$delimiter) {
            // Use the default delimiter
            $delimiter = '.';
        }

        // The path has already been separated into keys
        $keys = $path;
        if (!carr::is_array($path)) {
            // Split the keys by delimiter
            $keys = explode($delimiter, $path);
        }

        // Set current $array to inner-most array path
        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (ctype_digit($key)) {
                // Make the key an integer
                $key = (int) $key;
            }

            if (!isset($array[$key])) {
                $array[$key] = array();
            }

            $array = & $array[$key];
        }

        // Set key on inner-most array
        $array[array_shift($keys)] = $value;
    }

    public static function path($array, $path, $default = NULL, $delimiter = NULL) {
        if (!carr::isArray($array)) {
            // This is not an array!
            return $default;
        }

        if (is_array($path)) {
            // The path has already been separated into keys
            $keys = $path;
        } else {
            if (array_key_exists($path, $array)) {
                // No need to do extra processing
                return $array[$path];
            }

            if ($delimiter === NULL) {
                // Use the default delimiter .
                $delimiter = '.';
            }

            // Remove starting delimiters and spaces
            $path = ltrim($path, "{$delimiter} ");

            // Remove ending delimiters, spaces, and wildcards
            $path = rtrim($path, "{$delimiter} *");

            // Split the keys by delimiter
            $keys = explode($delimiter, $path);
        }

        do {
            $key = array_shift($keys);

            if (ctype_digit($key)) {
                // Make the key an integer
                $key = (int) $key;
            }

            if (isset($array[$key])) {
                if ($keys) {
                    if (carr::isArray($array[$key])) {
                        // Dig down into the next part of the path
                        $array = $array[$key];
                    } else {
                        // Unable to dig deeper
                        break;
                    }
                } else {
                    // Found the path requested
                    return $array[$key];
                }
            } elseif ($key === '*') {
                // Handle wildcards

                $values = array();
                foreach ($array as $arr) {
                    if ($value = carr::path($arr, implode('.', $keys))) {
                        $values[] = $value;
                    }
                }

                if ($values) {
                    // Found the values requested
                    return $values;
                } else {
                    // Unable to dig deeper
                    break;
                }
            } else {
                // Unable to dig deeper
                break;
            }
        } while ($keys);

        // Unable to find the value requested
        return $default;
    }

    public static function isArray($value) {
        if (is_array($value)) {
            // Definitely an array
            return TRUE;
        } else {
            // Possibly a Traversable object, functionally the same as an array
            return (is_object($value) AND $value instanceof Traversable);
        }
    }

    public static function is_array($value) {
        return static::isArray($value);
    }
}
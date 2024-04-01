<?php

namespace App\Http\Common\Tools;

use Closure;

class DotNotationHelper
{
    public static function extractByDotNotation($paths, $data, $mergeable = false)
    {
        $self = new DotNotationHelper();
        $result = null;

        foreach ($paths as $path => $single_path_formatter) {
            // Each path can be specified as:
            // 1. function
            // 2. String
            // 3. path => formatter
            // If $path is not a string, then it's either case 1 or 2,
            // hence the value of $path is the array index. Replace it
            // with function or string
            if (!is_string($path)) {
                $path = $single_path_formatter;
                $single_path_formatter = null;
            }

            $value = $self->extract($path, $data);

            if ($value || $value === false || $value === 0) {
                if ($single_path_formatter instanceof Closure) {
                    $value = $single_path_formatter($value);
                }
                if (!$mergeable) {
                    return $value;
                }

                // If we specify the paths mergeable, do not stop on the first find
                $result = array_merge($result ?? [], $value);
            }
        }

        return $result;
    }

    protected function extract($path, $source)
    {
        if ($path instanceof Closure) {
            return $path($source);
        }

        return $this->traverse($path, $source);
    }

    protected function traverse($path, $source)
    {
        $source = (array) $source;
        $parts = explode('.', $path);

        $first = array_shift($parts);
        $rest = implode('.', $parts);

        if (!isset($source[$first])) {
            return null;
        }

        $new_source = $source[$first];
        if ($rest) {
            return $this->traverse($rest, $new_source);
        }

        return $new_source;
    }
}

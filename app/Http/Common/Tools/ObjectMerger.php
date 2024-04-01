<?php

namespace App\Http\Common\Tools;

use Closure;

class ObjectMerger
{
    public function __construct($context_schema)
    {
        $this->context_schema = $context_schema;
    }

    public function merge($data)
    {
        $result = [];

        foreach ($this->context_schema as $name => $schema) {
            if ($schema['path'] instanceof Closure) {
                $result[$name] = $schema['path']($data);
            } else {
                $result[$name] = DotNotationHelper::extractByDotNotation($schema['path'], $data);
            }
        }

        return $result;
    }
}

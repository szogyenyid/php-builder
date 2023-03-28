<?php

namespace Szogyenyid\PhpBuilder;

use Exception;

class BuilderException extends Exception
{
    public static function invalidMethodName(string $methodName): self
    {
        return new self(sprintf('Builder method names must start with "with". Invalid method name: %s', $methodName));
    }

    public static function notSettable(string $property, string $class): self
    {
        return new self(sprintf('No property with name: %s found in class: %s', $property, $class));
    }
}

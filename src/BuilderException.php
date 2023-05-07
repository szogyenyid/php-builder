<?php

namespace Szogyenyid\PhpBuilder;

use Exception;

/**
 * This exception is thrown when something goes wrong with the Builder.
 */
class BuilderException extends Exception
{
    /**
     * This exception is thrown when an invalid method is called on the Builder.
     *
     * @param string $methodName The name of the invalid method.
     * @return self
     */
    public static function invalidMethodName(string $methodName): self
    {
        return new self(sprintf('Builder method names must start with "with". Invalid method name: %s', $methodName));
    }

    /**
     * This exception is thrown when a non-existing property is tried to be set.
     *
     * @param string $property The name of the non-existing property.
     * @param string $class    The name of the class.
     * @return self
     */
    public static function notSettable(string $property, string $class): self
    {
        return new self(sprintf('No property with name: %s found in class: %s', $property, $class));
    }
}

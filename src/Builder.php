<?php

namespace Szogyenyid\PhpBuilder;

use ReflectionClass;
use ReflectionException;

/**
 * This trait allows you to automagically create a Builder (Design Pattern) for your class.
 */
trait Builder
{
    /**
     * This method returns a builder object. It can be used with your class' setter methods by changing "set" to "with".
     */
    public static function builder()
    {
        return new class ($outerClass = static::class) {
            private object $instance;
            private string $outerClass;
            public function __construct(string $outerClass)
            {
                $this->outerClass = $outerClass;
                $this->reset();
            }
            /**
             * Instantiate a new instance of the class to be built.
             *
             * @return void
             */
            public function reset(): void
            {
                $class = $this->outerClass;
                $this->instance = new $class();
            }
            /**
             * Build and return the built instance of the class.
             *
             * @return object
             */
            public function build(): object
            {
                return $this->instance;
            }
            /**
             * This method is called when a method is called on the builder object.
             * It will try to find a setter method for the attribute and call it with the given value.
             *
             * @param string $name
             * @param array $arguments
             * @return self
             */
            public function __call($name, $arguments)
            {
                if (!str_starts_with($name, 'with')) {
                    throw BuilderException::invalidMethodName($name);
                }
                $property = lcfirst(str_replace('with', '', $name));
                if ($setter = $this->getSetterName($property)) {
                    $this->instance->$setter($arguments[0]);
                    return $this;
                }
                if ($prop = $this->getPublicPropery($property)) {
                    $this->instance->$prop = $arguments[0];
                    return $this;
                }
                throw BuilderException::notSettable($property, $this->outerClass);
            }
            private function getSetterName(string $property): ?string
            {
                $setterName = 'set' . ucfirst($property);
                $rc = new ReflectionClass($this->outerClass);
                if (
                    !in_array(
                        $setterName,
                        array_map(
                            function ($e) {
                                return $e->getName();
                            },
                            $rc->getMethods()
                        )
                    )
                ) {
                    return null;
                }
                return $setterName;
            }
            private function getPublicPropery(string $property): ?string
            {
                $rc = new ReflectionClass($this->outerClass);
                try {
                    $prop = $rc->getProperty($property);
                    if ($prop->isPublic()) {
                        return $property;
                    }
                    return null;
                } catch (ReflectionException $e) {
                    return null;
                }
            }
        };
    }
}

<?php

namespace Tests;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Reflection Helpers
 */
trait ReflectionHelpersTrait
{
    /**
     * Return a reflection property for the provided class and property
     *
     * @param string $class
     * @param string $property
     * @return ReflectionProperty
     * @throws ReflectionException
     */
    public function getReflectionProperty(string $class, string $property): ReflectionProperty
    {
        $reflector = new ReflectionClass($class);
        $property  = $reflector->getProperty($property);
        $property->setAccessible(true);

        return $property;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 29.01.2018
 * Time: 22:47
 */

namespace Tests\Helpers;


trait PrivateMethodTrait
{
    /**
     * @param string $classNamespace
     * @param string $method
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    private function makePublicMethod(string $classNamespace, string $method)
    {
        $class = new \ReflectionClass($classNamespace);
        $reflectMethod = $class->getMethod($method);
        $reflectMethod->setAccessible(true);
        return $reflectMethod;
    }
}
<?php

namespace Adiungo\Core\Tests\Traits;

use ReflectionClass;
use ReflectionException;

trait With_Inaccessible_Methods
{

    /**
     * @throws ReflectionException
     */
    protected function call_inaccessible_method($object, $method_name, ...$args)
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($method_name);
        /** @noinspection PhpExpressionResultUnusedInspection */
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }

}
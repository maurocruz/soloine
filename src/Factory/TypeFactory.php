<?php

declare(strict_types=1);

namespace Plinct\Soloine\Factory;

use Plinct\Soloine\Interfaces\FactoryTypeInterface;
use Plinct\Soloine\Type\TypeDefault;

class TypeFactory implements FactoryTypeInterface
{
    /**
     * @param string $type
     * @param array|null $params
     * @return string
     */
    public static function created(string $type, array $params = null): string
    {
        return TypeDefault::createType($type, $params);
    }
}
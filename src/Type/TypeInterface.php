<?php

declare(strict_types=1);

namespace Plinct\Soloine\Type;

interface TypeInterface
{
    public static function createType(string $class, array $params = null): string;
}
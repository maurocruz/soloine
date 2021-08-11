<?php

declare(strict_types=1);

namespace Plinct\Soloine\Type;

interface TypeInterface
{
    public static function createType(array $params = null): string;
}
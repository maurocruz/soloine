<?php

declare(strict_types=1);

namespace Plinct\Soloine\Interfaces;

interface FactoryTypeInterface
{
    public static function created(string $type, array $params = null): string;
}
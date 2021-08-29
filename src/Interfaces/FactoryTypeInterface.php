<?php

declare(strict_types=1);

namespace Plinct\Soloine\Interfaces;

interface FactoryTypeInterface
{
    /**
     * @param string $type
     * @param array|null $params
     * @return string
     */
    public static function create(string $type, array $params = null): string;
}
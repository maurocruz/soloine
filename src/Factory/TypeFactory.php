<?php

declare(strict_types=1);

namespace Plinct\Soloine\Factory;

use Plinct\Soloine\Interfaces\FactoryTypeInterface;
use Plinct\Soloine\Type\ServiceType;

class TypeFactory implements FactoryTypeInterface
{
    public static function created(string $type, array $params = null): string
    {
        return match ($type) {
            'service' => ServiceType::createType($params),
            default => _("No type found!")
        };
    }
}
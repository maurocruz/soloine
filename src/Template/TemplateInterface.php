<?php

declare(strict_types=1);

namespace Plinct\Soloine\Template;

interface TemplateInterface
{
    public function setContext(array $context);

    public function setId(string $id);

    public function setType(string $type);

    public function setProperty(string $name, mixed $value);

    public function setProperties(array $propertiesArray);

    public function ready();
}
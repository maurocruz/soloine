<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

interface ServerInterface
{
    /**
     * @param string $id
     */
    public function selectThing(string $id);

    /**
     * @param bool $includeSubClass
     */
    public function includeSubClass(bool $includeSubClass = true);

    /**
     * @return bool
     */
    public function classExists(): bool;

    /**
     * @param string $format
     */
    public function format(string $format);

    /**
     * @return string
     */
    public function render(): string;

}

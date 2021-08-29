<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

interface ServerInterface
{
    /**
     * @param string $id
     */
    public function selectById(string $id);

    /**
     * @param string $label
     */
    public function selectByLabel(string $label);

    /**
     * @return bool
     */
    public function classExists(): bool;

    /**
     * @return string
     */
    public function render(): string;

}

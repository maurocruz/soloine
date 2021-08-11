<?php

namespace Plinct\Soloine\Server;

interface ServerInterface
{
    /**
     * @param string $idname
     */
    public function selectThing(string $idname);

    /**
     * @return array
     */
    public function ready(): array;
}
<?php

namespace Plinct\Soloine\Server;

interface ServerInterface
{
    /**
     * @param string $idname
     */
    public function selectThing(string $idname);


    public function includeSubClass();

    /**
     * @return string
     */
    public function ready(): string;
}
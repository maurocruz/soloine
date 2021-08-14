<?php

namespace Plinct\Soloine\Type;

use Plinct\Soloine\Server\Server;

class TypeDefault implements TypeInterface
{
    /**
     * @param string $class
     * @param array|null $params
     * @return string
     */
    public static function createType(string $class, array $params = null): string
    {
        $server = new Server();

        // SUB CLASS
        if (isset($params['subClass'])) {
            $server->includeSubClass();
        }

        // SELECT THING
        $server->selectThing("schema:".ucfirst($class));

        // FORMAT
        if (isset($params['format'])) {
            $server->format($params['format']);
        }

        // RENDER
        return $server->render();
    }
}

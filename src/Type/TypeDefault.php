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
        $server->selectThing(ucfirst($class));

        if (isset($params['subClass']) && $server->getId()) {
           $server->includeSubClass();
        }

        return $server->ready();
    }
}
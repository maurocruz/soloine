<?php

declare(strict_types=1);

namespace Plinct\Soloine\Type;

use Plinct\Soloine\Template\Template;
use Plinct\Soloine\Server\Server;

class ServiceType implements TypeInterface
{
    /**
     * @param array|null $params
     * @return string
     */
    public static function createType(array $params = null): string
    {
        // SERVER
        $server = new Server();
        $server->selectThing('Service');
        $data = $server->ready();

        // TEMPLATE
        $template = new Template('Service');
        $template->setContext($data['@context']);
        $graph = $data['@graph'];
        $template->setId($graph['@id']);
        $template->setType($graph['@type']);
        $template->setProperty('name',$graph['rdfs:label']);
        $template->setProperty('description',$graph['rdfs:comment']);
        $template->setProperty('subClassOf',$graph['rdfs:subClassOf']);

        // RESPONSE
        return $template->ready();
    }
}
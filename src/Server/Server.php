<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;


class Server extends ServerAbstract implements ServerInterface
{
    /**
     * @param string|null $urlApi
     */
    public function __construct(string $urlApi = null)
    {
        $this->setData($urlApi);
    }

    /**
     * @param string $idname
     */
    public function selectThing(string $idname)
    {
        foreach ($this->graph as $value) {
            if ($value['@id'] == "schema:$idname") {
                $this->setGraph($value);
            }
        }
    }

    /**
     * @return array
     */
    public function ready(): array
    {
        $this->data['@context'] = $this->context;
        $this->data['@graph'] = $this->graph;

        return $this->data;
    }
}
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
        $id = "schema:$idname";
        foreach ($this->graph as $value) {
            if ($value['@id'] == $id) {
                $this->id = $value['@id'];
                $newGraph = $value;
            }
        }
        $this->setGraph($newGraph ?? ['message'=>'No class found']);
    }

    public function includeSubClass()
    {
        $graph = $this->data['@graph'];
        foreach ($graph as $value) {
            $subClassOf = $value['rdfs:subClassOf'] ?? null;
            if ($subClassOf) {
                if (isset($subClassOf['@id']) && $subClassOf['@id'] == $this->id) {
                    $this->setSuperClassOf(['@id'=>$value['@id']]);
                } elseif(count($subClassOf) > 1) {
                    foreach ($subClassOf as $item) {
                        $itemId = $item['@id'] ?? null;
                        if ($itemId && $itemId == $this->id) {
                            $this->setSuperClassOf(['@id'=>$value['@id']]);
                        }
                    }
                }
            }
        }
        $this->graph['superClassOf'] = $this->superClassOf;
    }

    /**
     * @return string
     */
    public final function ready(): string
    {
        $this->data['@context'] = $this->context;
        $this->data['@graph'] = $this->graph;

        return json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

abstract class ServerAbstract
{
    const SCHEMAORG_FILE = __DIR__.'/../../static/data/schemaorg.json';
    /**
     * @var array
     */
    protected array $data;
    /**
     * @var array
     */
    protected array $context;
    /**
     * @var array
     */
    protected array $graph;
    /**
     * @var array|null
     */
    protected ?array $superClass = null;
    /**
     * @var string|null
     */
    protected ?string $id = null;
    /**
     * @var array|null
     */
    protected ?array $subClass = null;
    /**
     * @var bool
     */
    protected bool $includeSubClass = false;
    /**
     * @var array|null
     */
    protected ?array $superClassOf = null;

    /**
     * @param string|null $apiUrl
     */
    protected function setData(string $apiUrl = null): void
    {
        $this->data = json_decode(file_get_contents($apiUrl ?? self::SCHEMAORG_FILE), true);

        $this->setContext($this->data['@context']);

        $this->setGraph($this->data['@graph']);
    }

    /**
     * @param array $context
     */
    protected function setContext(array $context): void
    {
        $this->context = $context;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param array $graph
     */
    protected function setGraph(array $graph): void
    {
        $this->graph = $graph;
    }

    /**
     * @param array|null $superClass
     */
    protected function setSuperClass(?array $superClass): void
    {
        $this->superClass = $superClass;
    }

    /**
     * @param array $subClassOf
     */
    protected function setSuperClassOf(array $subClassOf): void
    {
        $this->superClassOf[] = $subClassOf;
    }

    protected function selectClass(string $id)
    {
        $class = null;

        foreach ($this->graph as $value) {
            if (isset($value['@id']) && $value['@id'] == $id) {
                $class = $value;
            }
        }

        if ($this->includeSubClass && $subClass = $this->addSubClass($class)) {
            $class['superClassOf'] = $subClass;
        }

        return $class;
    }

    /**
     * @param array|null $class
     */
    protected function addSubClass(array $class = null): ?array
    {
        $subClass = null;

        foreach ($this->data['@graph'] as $value) {
            $subClassOf = $value['rdfs:subClassOf'] ?? null;

            if ($subClassOf) {
                if (isset($subClassOf['@id']) && $subClassOf['@id'] == $class['@id']) {
                   $subClass[] = $this->selectClass($value['@id']);

                } elseif(count($subClassOf) > 1) {
                    foreach ($subClassOf as $item) {
                        $itemId = $item['@id'] ?? null;

                        if ($itemId && $itemId == $class['@id']) {
                            $subClass[] = $this->selectClass($value['@id']);
                        }
                    }
                }
            }
        }

        return $subClass;
    }
}

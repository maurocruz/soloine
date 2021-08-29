<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

use Plinct\Soloine\Format\Format;

abstract class ServerAbstract
{
    /**
     * @var array
     */
    protected static array $data;
    /**
     * @var array
     */
    protected array $params;
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
     * @var string|null
     */
    protected ?string $label = null;
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

    protected function selectClass($id)
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

        foreach (self::$data['@graph'] as $value) {
            $subClassOf = $value['rdfs:subClassOf'] ?? null;

            if ($subClassOf && isset($class['@id'])) {
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

    /**
     *
     */
    protected function format()
    {
        if ($this->superClass) {

            $format = new Format($this->superClass);

            $this->superClass = match ($this->params['format']) {
                'hierarchyText' => $format->hierarchyText(),
                'breadcrumb' => isset($this->params['subClass']) ? $format->breadcrumb($this->params['subClass']) : null
            };

        } else {
            $this->superClass = [ "message" => "class '$this->id' not exists" ];
        }
    }
}

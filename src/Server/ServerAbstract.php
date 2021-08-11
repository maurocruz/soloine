<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

class ServerAbstract
{
    const SCHEMAORG_FILE = __DIR__.'/../../static/data/schemaorg.json';
    /**
     * @var array
     */
    protected array $data;

    protected array $context;

    protected array $graph;

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
    public function setContext(array $context): void
    {
        $this->context = $context;
    }

    /**
     * @param array $graph
     */
    public function setGraph(array $graph): void
    {
        $this->graph = $graph;
    }
}

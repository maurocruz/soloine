<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

use Plinct\Soloine\Format\Format;

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
     * @param string $id
     */
    public function selectThing(string $id)
    {
        $this->superClass = parent::selectClass($id);
    }

    /**
     * @param bool $includeSubClass
     */
    public function includeSubClass(bool $includeSubClass = true)
    {
        $this->includeSubClass = $includeSubClass;
    }

    /**
     * @return bool
     */
    public function classExists(): bool
    {
        return (bool)$this->id;
    }

    public function format(string $format)
    {
        if ($format == "hierarchyText") {
            $this->superClass = (new Format())->hierarchyText($this->superClass);
        }
    }

    /**
     * @return string
     */
    public final function render(): string
    {
        $this->data['@context'] = $this->context;
        $this->data['@graph'] = $this->superClass;

        return json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

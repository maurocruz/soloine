<?php

declare(strict_types=1);

namespace Plinct\Soloine\Server;

class Server extends ServerAbstract implements ServerInterface
{
    /**
     * @param array|null $params
     */
    public function __construct(array $params = null)
    {
        $this->params = $params;
    }

    /**
     * @param string|null $apiUrl
     */
    public function setData(string $apiUrl = null): void
    {
        self::$data = json_decode(file_get_contents($apiUrl), true);

        self::$data['@context']["source"] = realpath($apiUrl);

        $this->setContext(self::$data['@context']);

        $this->setGraph(self::$data['@graph']);
    }

    public static function searchById(string $id): bool
    {
        foreach (self::$data['@graph'] as $item) {
            if ($item['@id'] == $id) {
                return $item;
            }
        }
        return false;
    }
    public static function searchByLabel(string $label): bool
    {
        foreach (self::$data['@graph'] as $item) {
            if ($item['rdfs:label'] == $label) {
                return $item;
            }
        }
        return false;
    }

    public function selectByLabel(string $label)
    {
        $this->label = $label;
    }

    /**
     * @param string $id
     */
    public function selectById(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function classExists(): bool
    {
        return (bool)$this->id;
    }


    /**
     * @return string
     */
    public final function render(): string
    {
        if (isset($this->params['subClass'])) {
            $this->includeSubClass = true;
        }

        if ($this->id) {
            $this->superClass = parent::selectClass($this->id);
        } elseif ($this->label) {
            $this->superClass = parent::selectClass($this->label);
        }


        // FORMAT
        if (isset($this->params['format'])) {
            parent::format();
        }

        $newData['@context'] = $this->context;
        $newData['@graph'] = $this->superClass;

        return json_encode($newData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

<?php

declare(strict_types=1);

namespace Plinct\Soloine\Format;

class FormatAbstract
{
    /**
     * @var array
     */
    protected array $list;

    /**
     * @param string $parent
     * @param array $class
     * @return array
     */
    protected function listSubClass(string $parent, array $class): array
    {
        $superClassOf = $class['superClassOf'] ?? null;
        $label = $class['rdfs:label'];

        $newParent = $parent . " > " . $label;
        $this->list[$label] = $newParent;

        if ($superClassOf) {
            foreach ($superClassOf as $item) {
                $label = $item['rdfs:label'];

                if (isset($item['superClassOf'])) {
                    self::listSubClass($newParent, $item);

                } else {
                    $this->list[$label] = $newParent . " > " . $label;
                }
            }
        }

        return $this->list;
    }
}

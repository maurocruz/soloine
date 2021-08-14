<?php

declare(strict_types=1);

namespace Plinct\Soloine\Format;

class Format extends FormatAbstract
{
    /**
     * @param $class
     * @return array
     */
    public function hierarchyText($class): array
    {
        $superClassOf = $class['superClassOf'] ?? null;

        $parent = $class['rdfs:label'];

        $this->list[$parent] = $parent;

        if ($superClassOf) {
            foreach ($superClassOf as $item) {
                parent::listSubClass($parent, $item);
            }
        }

        return $this->list;
    }
}
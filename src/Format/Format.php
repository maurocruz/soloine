<?php

declare(strict_types=1);

namespace Plinct\Soloine\Format;

use Plinct\Soloine\RdfsObject\RdfsObject;

class Format
{
    protected RdfsObject $class;

    /**
     * @param array $class
     */
    public function __construct(array $class)
    {
        $this->class = new RdfsObject($class);
    }

    /**
     * @return array
     */
    public function hierarchyText(): array
    {
        return $this->class->listSubClass();
    }

    /**
     * @param $subClass
     * @return array
     */
    public function breadcrumb($subClass): array
    {
        $subClass = ucfirst($subClass);

        $listSubClass = $this->class->listSubClass();

        if (array_key_exists($subClass, $listSubClass)) {
            return [
                "breadcrumb" => $listSubClass[$subClass]
            ];
        }
        return [ 'breadcrumb' => $this->class->getLabel() ];
    }
}
<?php

declare(strict_types=1);

namespace Plinct\Soloine\Template;

class Template extends TemplateAbstract implements TemplateInterface
{
    /**
     * @param string $class
     */
    public function __construct(string $class = "Thing")
    {
        $this->class = $class;
    }

    /**
     * @return bool|string
     */
    public function ready(): bool|string
    {
        return json_encode($this->template, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
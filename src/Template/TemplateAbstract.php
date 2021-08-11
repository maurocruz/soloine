<?php

declare(strict_types=1);

namespace Plinct\Soloine\Template;

abstract class TemplateAbstract
{
    /**
     * @var array
     */
    protected array $template = [];
    /**
     * @var string
     */
    protected string $class;

    /**
     * @param array $context
     */
    public function setContext(array $context)
    {
        $this->template['@context'] = $context;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->template['@id'] = $id;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->template['@type'] = $type;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setProperty(string $name, mixed $value)
    {
        $this->template[$name] = $value;
    }

    /**
     * @param array $propertiesArray
     */
    public function setProperties(array $propertiesArray)
    {
        $this->template = array_merge($this->template, $propertiesArray);
    }
}
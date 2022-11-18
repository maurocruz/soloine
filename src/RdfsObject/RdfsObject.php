<?php

declare(strict_types=1);

namespace Plinct\Soloine\RdfsObject;

class RdfsObject
{
  /**
   * @var string|mixed
   */
  private string $id;
  /**
   * @var string|mixed
   */
  private string $label;
  /**
   * @var array|mixed|null
   */
  private ?array $subClassOf;
  /**
   * @var array|mixed|null
   */
  private ?array $superClassOf;

  /**
   * @param array $rdfsObject
   */
  public function __construct(private array $rdfsObject)
  {
    $this->id = $this->rdfsObject['@id'];
    $this->label = is_array($this->rdfsObject['rdfs:label']) ? $this->rdfsObject['rdfs:label']['@value'] : $this->rdfsObject['rdfs:label'];
    $this->subClassOf = $this->rdfsObject['rdfs:subClassOf'] ?? null;
    $this->superClassOf = $this->rdfsObject['subClass'] ?? null;
  }

  /**
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getLabel(): string
  {
    return $this->label;
  }

  /**
   * @return array|null
   */
  public function getSuperClassOf(): ?array
  {
    return $this->superClassOf;
  }

	/**
	 * @return array|string|null
	 */
  public function getSubClassOf(): array|string|null
  {
    return $this->subClassOf['@id'] ?? $this->subClassOf;
  }

  /**
   * @param string $superClassId
   * @return bool
   */
  public function isSubClassOf(string $superClassId): bool
  {
    if ($this->subClassOf) {
      if (isset($this->subClassOf['@id']) && $this->subClassOf['@id'] == $superClassId) {
        return true;
      } else {
        foreach($this->subClassOf as $item) {
          if ($item['@id'] == $superClassId) {
            return true;
          }
        }
      }
    }
    return false;
  }

  /**
   * @var array
   */
  private array $list = [];

  /**
   * @param RdfsObject|null $classObject
   * @param string|null $prefix
   * @return array|null
   */
  public function listSubClass(RdfsObject $classObject = null, string $prefix = null): ?array
  {
    $classObject = $classObject ?? $this;

    $newPrefix = $prefix ? $prefix . " > " . $classObject->getLabel() : $classObject->getLabel();
    $this->list[$classObject->getLabel()] = $newPrefix;

    // exists sub classes ?
    if (isset($classObject->superClassOf)) {

      foreach ($classObject->superClassOf as $subClass) {
        $rdfsItem = new RdfsObject($subClass);

        if (isset($rdfsItem->superClassOf)) {
          $this->listSubClass($rdfsItem, $newPrefix);

        } else {
         $this->list[$rdfsItem->getLabel()] = $newPrefix . " > " . $rdfsItem->getLabel();
        }
      }
    }

    return $this->list;
  }
}

<?php

declare(strict_types=1);

namespace Plinct\Soloine\Factory;

use Plinct\Soloine\Server\Server;
use Plinct\Soloine\Soloine;

class SoloineFactory
{
  /**
   * @return Soloine
   */
  public static function created(): Soloine {
    return new Soloine();
  }

	/**
	 * @param string $class
	 * @param array $params
	 * @return string
	 */
  public static function category(string $class, array $params): string
  {
    $source = $params['source'];

    $sourceCategory = __DIR__ . "/../../static/data/$source.json";

    if(file_exists($sourceCategory)) {
      $server = new Server($params);
      $server->setData($sourceCategory);
      $server->selectByLabel(ucfirst($class));
      return $server->render();
    }

    return json_encode(['message'=>'Class not found!']);
  }

	/**
	 * @param string $class
	 * @param array|null $params
	 * @return string
	 */
  public static function schemaorg(string $class, array $params = null): string
  {
    $sourceFile = __DIR__."/../../static/data/schemaorg.json";

    $server = new Server($params);
    $server->setData($sourceFile);
    $server->selectById("schema:".ucfirst($class));
    return $server->render();
  }
}

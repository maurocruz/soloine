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
     * @param $params
     * @return string
     */
    public static function category($params): string
    {
        $class = $params['class'];
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
     * @param array|null $params
     * @return string
     */
    public static function schemaorg(array $params = null): string
    {
        $class = $params['class'];
        $sourceFile = __DIR__."/../../static/data/schemaorg.json";

        $server = new Server($params);
        $server->setData($sourceFile);
        $server->selectById("schema:".ucfirst($class));
        return $server->render();
    }
}

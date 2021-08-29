<?php
namespace Plinct\Soloine\Factory;

use JetBrains\PhpStorm\Pure;
use Plinct\Soloine\Server\Server;
use Plinct\Soloine\Soloine;

class SoloineFactory
{
    /**
     * @return Soloine
     */
    #[Pure] public static function created(): Soloine {
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

        $fileName = $class.ucfirst($source);

        $sourceFile = __DIR__ . "/../../static/data/$fileName.json";

        if(file_exists($sourceFile)) {
            $server = new Server($params);
            $server->setData($sourceFile);
            $server->selectById("schema:" . ucfirst($class));
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
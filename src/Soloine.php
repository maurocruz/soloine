<?php

declare(strict_types=1);

namespace Plinct\Soloine;

use Plinct\Soloine\Factory\SoloineFactory;
use Slim\App as SlimApp;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;

class Soloine
{
    /**
     * @var string
     */
    private static string $API_URL;
    /**
     * @var string
     */
    private static string $schema;
    /**
     * @var string
     */
    private static string $schemaData;

    /**
     * @param string $API_URL
     * @return Soloine
     */
    public function setAPIURL(string $API_URL): Soloine
    {
        self::$API_URL = $API_URL;
        return $this;
    }

    /**
     * @return string
     */
    public static function getAPIURL(): string
    {
        return self::$API_URL;
    }

    /**
     * @param string $schema
     * @return Soloine
     */
    public function setSchema(string $schema): Soloine
    {
        self::$schema = $schema;
        return $this;
    }

    /**
     * @return string
     */
    public static function getSchema(): string
    {
        return self::$schema;
    }

    /**
     * @param string $schemaData
     * @return Soloine
     */
    public function setschemaData(string $schemaData): Soloine
    {
        self::$schemaData = $schemaData;
        return $this;
    }

    /**
     * @return string
     */
    public static function getschemaData(): string
    {
        return self::$schemaData;
    }

    /**
     * @param SlimApp $route
     */
    public function routes(SlimApp $route)
    {
        $route->get('/soloine/[{type}]', function (Request $request, ResponseInterface $response, $args)
        {
            $params = $request->getQueryParams();
            $source = $params['source'] ?? null;
            $class = $params['class'] ?? null;
            $output = $params['output'] ?? null;

            if ($source == 'category') {
                $content = SoloineFactory::category($params);
            } elseif ($class) {
                $content = SoloineFactory::schemaorg($params);
            } else {
                $content = file_get_contents(__DIR__.'/../composer.json');
            }

            $contentType = $output == 'html' ? "text/html" : "application/json";

            $response = $response->withHeader('Content-Type', $contentType);
            $response = $response->withHeader('Access-Control-Allow-Origin', '*');
            $response->getBody()->write($content);

            return $response;
        });
    }
}

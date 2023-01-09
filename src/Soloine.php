<?php

declare(strict_types=1);

namespace Plinct\Soloine;

use Plinct\Api\Middleware\CorsMiddleware;
use Plinct\Soloine\Factory\SoloineFactory;
use Slim\App as SlimApp;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Slim\Routing\RouteCollectorProxy as Route;

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
  public function routes(SlimApp $route): void
  {
		$route->group('/soloine', function (Route $route)
		{
			$route->options('/{class}', function (Request $request, ResponseInterface $response) {
				return $response;
			});

			$route->get('/[{class}]', function (Request $request, ResponseInterface $response, $args) {
				$params = $request->getQueryParams();
				$source = $params['source'] ?? null;
				$class = $args['class'] ?? null;

				if ($source == 'serviceCategory') {
					$content = SoloineFactory::category($class, $params);
				} elseif ($class) {
					$content = SoloineFactory::schemaorg($class, $params);
				} else {
					$content = file_get_contents(__DIR__ . '/../composer.json');
				}

				$response->getBody()->write($content);

				return $response;
			});

		})->addMiddleware(new CorsMiddleware([
			"Content-type" => "application/json",
			"Access-Control-Allow-Origin" => '*',
			"Access-Control-Allow-Headers" => "origin, x-requested-with, content-type, x-ijt, authorization",
	    "Access-Control-Allow-Methods" => "PUT, GET, POST, DELETE, OPTIONS"
		]));
  }
}

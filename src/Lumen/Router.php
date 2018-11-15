<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/15
 * Time: 8:05
 */

namespace KeepXin\Lumen;

use Laravel\Lumen\Routing\Router as LumenRouter;

class Router extends LumenRouter
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Add a route to the collection.
     *
     * @param  array|string $method
     * @param  string $uri
     * @param  mixed $action
     * @return void
     */
    public function addRoute($method, $uri, $action)
    {
        $action = $this->parseAction($action);

        $attributes = null;

        if ($this->hasGroupStack()) {
            $attributes = $this->mergeWithLastGroup([]);
        }

        $version = '';

        if (isset($attributes) && is_array($attributes)) {
            if (isset($attributes['prefix'])) {
                $uri = trim($attributes['prefix'], '/') . '/' . trim($uri, '/');
            }

            if (isset($attributes['suffix'])) {
                $uri = trim($uri, '/') . rtrim($attributes['suffix'], '/');
            }

            if (isset($attributes['version'])) {
                $version = $attributes['version'];
            } else {
                $version = "1";
            }

            $action = $this->mergeGroupAttributes($action, $attributes);
        }

        $uri = '/' . trim($uri, '/');

        if (isset($action['as'])) {
            $this->namedRoutes[$action['as']] = $uri;
        }

        if (is_array($method)) {
            foreach ($method as $verb) {
                $this->routes[$version][$verb . $uri] = ['method' => $verb, 'uri' => $uri, 'action' => $action];
            }
        } else {
            $this->routes[$version][$method . $uri] = ['method' => $method, 'uri' => $uri, 'action' => $action];
        }
    }

}

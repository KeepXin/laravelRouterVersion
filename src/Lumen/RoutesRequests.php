<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/15
 * Time: 8:23
 */
namespace KeepXin\Lumen;
use Laravel\Lumen\Concerns\RoutesRequests as LumenRoutesRequests;

use Exception;
use Throwable;
use Laravel\Lumen\Http\Request as LumenRequest;


trait RoutesRequests
{
    use LumenRoutesRequests;

    /**
     * @param null $request
     * @return \Illuminate\Http\Response|mixed
     */
    public function dispatch($request = null)
    {
        list($method, $pathInfo) = $this->parseIncomingRequest($request);

        $version = $this->getVersion($request);
        $router = $this->router->getRoutes();
        if(!isset($router[$version]) || !$router[$version]){
            throw new \RuntimeException('unknown route version');
        }
        $router = $router[$version];

        try {
            $this->boot();

            return $this->sendThroughPipeline($this->middleware, function () use ($method, $pathInfo,$router) {
                if (isset($router[$method . $pathInfo])) {
                    return $this->handleFoundRoute([true, $router[$method . $pathInfo]['action'], []]);
                }
                return $this->handleDispatcherResponse(
                    $this->createDispatcher()->dispatch($method, $pathInfo)
                );
            });
        } catch (Exception $e) {
            return $this->prepareResponse($this->sendExceptionToHandler($e));
        } catch (Throwable $e) {
            return $this->prepareResponse($this->sendExceptionToHandler($e));
        }
    }

    public function getVersion($request){
        if (! $request) {
            $request = LumenRequest::capture();
        }

        return  $request->header('version', 'v1');
    }


}

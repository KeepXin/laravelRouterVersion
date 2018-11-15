<?php

namespace KeepXin\Lumen;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/14
 * Time: 22:25
 */
use Laravel\Lumen\Application as LumenApplication;

class Application extends LumenApplication
{
    use RoutesRequests;
    public function __construct(?string $basePath = null)
    {
        parent::__construct($basePath);
    }

    /**
     * Bootstrap the router instance.
     *
     * @return void
     */
    public function bootstrapRouter()
    {
        $this->router = new Router($this);
    }

}

<?php

namespace App;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/14
 * Time: 22:25
 */
use Laravel\Lumen\Application;

class LumenApplication extends Application
{
    use LumenRoutesRequests;
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
        $this->router = new LumenRouter($this);
    }

}
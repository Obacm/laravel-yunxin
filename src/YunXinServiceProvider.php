<?php

namespace Obacm\YunXin;

use Illuminate\Support\ServiceProvider;

/**
 * Class YunXinServiceProvider
 * @package Obacm\Yunxin
 */
class YunXinServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerConfig();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/yunxin.php', 'yunxin'
        );
    }

    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/yunxin.php' => \config_path('yunxin.php'),
        ], 'yunxin-config');
    }
}
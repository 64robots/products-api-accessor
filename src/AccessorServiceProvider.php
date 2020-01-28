<?php

namespace R64\ProductsApiAccessor;

use Illuminate\Support\ServiceProvider;
use R64\ProductsApiAccessor\Command\GenerateProductsApiAccessToken;

class AccessorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/products.php' => config_path('products.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateProductsApiAccessToken::class,
            ]);
        }
    }
}
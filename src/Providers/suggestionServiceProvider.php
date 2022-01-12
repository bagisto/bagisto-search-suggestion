<?php

namespace Webkul\suggestion\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;


class suggestionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/../Http/admin-routes.php');

        $this->loadRoutesFrom(__DIR__ . '/../Http/shop-routes.php');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'suggestion');

        $this->publishes([
            __DIR__ . '/../../publishable/assets' => public_path('themes/default/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/header/index.blade.php' => resource_path('themes/velocity/views/layouts/header/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/default/header/index.blade.php' => resource_path('themes/default/views/layouts/header/index.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../Resources/views/shop/velocity/header/particals.blade.php' => resource_path('themes/velocity/views/UI/particals.blade.php'),
        ]);

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'suggestion');

        Event::listen('bagisto.shop.layout.head', function($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('suggestion::shop.layouts.style');
            });

        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }
}
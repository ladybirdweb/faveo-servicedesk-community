<?php

namespace App\Itil;

use Illuminate\Support\ServiceProvider;

class ItilServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $view_path = app_path().DIRECTORY_SEPARATOR.'Itil'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'itil');

        $lang_path = app_path().DIRECTORY_SEPARATOR.'Itil'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($lang_path, 'itil');

        if (isInstall()) {
            $controller = new Controllers\ActivateController();
            $controller->activate();
        }

        if (class_exists('Breadcrumbs')) {
            require __DIR__.'/breadcrumbs.php';
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Add routes
        if (isInstall()) {
            $routes = app_path('/Itil/routes.php');
            if (file_exists($routes)) {
                require $routes;
            }
        }
    }
}

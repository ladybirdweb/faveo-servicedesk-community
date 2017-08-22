<?php

namespace App\Plugins\ServiceDesk;

class ServiceProvider extends \App\Plugins\ServiceProvider
{
    public function register()
    {
        parent::register('ServiceDesk');
    }

    public function boot()
    {
        /**
         * Migrations.
         */
        $path = __DIR__.'/database/migrations';
        $this->publishes([
            $path => database_path('/migrations/test'),
                ], 'migrations');

        /**
         * Views.
         */
        $view_path = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'ServiceDesk'.DIRECTORY_SEPARATOR.'views';
        $this->loadViewsFrom($view_path, 'service');

        /**
         * Translation.
         */
        $trans = app_path().DIRECTORY_SEPARATOR.'Plugins'.DIRECTORY_SEPARATOR.'ServiceDesk'.DIRECTORY_SEPARATOR.'lang';
        $this->loadTranslationsFrom($trans, 'service');
        $controller = new \App\Plugins\ServiceDesk\Controllers\ActivateController();
        $a = $controller->activate();

        $controller = new Controllers\ActivateController();
        $controller->activate();

        if (class_exists('Breadcrumbs')) {
            require __DIR__.'/breadcrumbs.php';
        }

        parent::boot('ServiceDesk');
    }
}

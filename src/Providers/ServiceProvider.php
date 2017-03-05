<?php

namespace Falur\Breadcrumbs\Providers;

use Falur\Breadcrumbs\Breadcrumbs;
use Falur\Breadcrumbs\Contracts\Breadcrumbs as BreadcrumbsContract;
use Falur\Breadcrumbs\BreadcrumbsFactory;
use Falur\Breadcrumbs\Contracts\BreadcrumbsFactory as BreadcrumbsFactoryContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $viewPath = __DIR__ . '/../../resources/views';

        $this->loadViewsFrom($viewPath, 'breadcrumbs');

        $this->publishes([
            $viewPath => resource_path('views/vendor/breadcrumbs'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(BreadcrumbsContract::class, Breadcrumbs::class);
        $this->app->alias(BreadcrumbsContract::class, 'breadcrumbs');

        $this->app->singleton(BreadcrumbsFactoryContract::class, BreadcrumbsFactory::class);
        $this->app->alias(BreadcrumbsFactoryContract::class, 'breadcrumbsFactory');
    }
}

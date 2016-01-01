<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Composers\NavigationBuilder\NavigationBuilder;
use Blade;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeNavigation();
        $this->composeBreadcrumb();
        $this->composePageMeta();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerNavigationBuilder();
        $this->app->alias('navigator', 'App\Http\Composers\NavigationBuilder\NavigationBuilder');
    }

    protected function registerNavigationBuilder()
    {
        $this->app->singleton('navigator', function($app)
        {
            return new NavigationBuilder();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('navigator', 'App\Http\Composers\NavigationBuilder\NavigationBuilder');
    }

    /**
     * Xử lý thanh side navigation
     */
    public function composeNavigation()
    {
        view()->composer('partials.admin._sidenav', 'App\Http\Composers\NavigationComposer@compose');
    }

    /**
     * Xử lý thanh breadcrumb
     */
    public function composeBreadcrumb()
    {
        view()->composer('partials.admin._breadcrumb', 'App\Http\Composers\BreadcrumbComposer@compose');
    }

    /**
     * Xử lý metadata của trang
     */
    public function composePageMeta()
    {
        view()->composer('partials.admin._pagemeta', 'App\Http\Composers\PageMetaComposer@compose');
    }
}

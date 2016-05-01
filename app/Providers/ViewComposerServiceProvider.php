<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->composeTopNav();
        $this->composeAdministrativeDivision();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

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

    public function composeTopNav()
    {
        view()->composer('partials.admin._topnav', 'App\Http\Composers\TopNavComposer@compose');
    }

    public function composeAdministrativeDivision()
    {
        view()->composer('admin.shop.order_create', 'App\Http\Composers\AdministrativeDivisionComposer@compose');
    }
}

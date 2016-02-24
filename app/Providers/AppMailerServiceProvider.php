<?php

namespace App\Providers;

use App\AppMailers\AppMailer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Mailer;

class AppMailerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAppMailer();
        $this->app->alias('appmailer', 'App\AppMailers\AppMailer');
    }

    protected function registerAppMailer()
    {
        $this->app->singleton('appmailer', function($app)
        {
            return new AppMailer(app('mailer'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('appmailer', 'App\AppMailers\AppMailer');
    }
}

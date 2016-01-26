<?php namespace App\AppMailers;

use Illuminate\Support\Facades\Facade;

class AppMailerFacade extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'appmailer'; }

}
<?php namespace App\Http\Composers\NavigationBuilder;

use Illuminate\Support\Facades\Facade;

class Navigator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'navigator'; }
}
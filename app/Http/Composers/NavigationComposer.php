<?php namespace App\Http\Composers;

use KouTsuneka\Navigation\Navigator;
use Illuminate\Contracts\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        $nav = app('navigator')->set_sort(true)->get_navigation();
        $view->with('acronym', $nav['acronym']);
        $view->with('menu_items', $nav['menu_items']);
    }
}
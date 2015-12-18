<?php namespace App\Http\Composers;

use App\Http\Composers\NavigationBuilder\Navigator;
use Illuminate\Contracts\View\View;

class NavigationComposer
{
    public function compose(View $view)
    {
        $nav = Navigator::set_sort(false)->get_navigation();
        $view->with('acronym', $nav['acronym']);
        $view->with('menu_items', $nav['menu_items']);
    }
}
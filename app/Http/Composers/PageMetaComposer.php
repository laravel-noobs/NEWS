<?php namespace App\Http\Composers;

use App\Http\Composers\NavigationBuilder\Navigator;
use Illuminate\Contracts\View\View;

class PageMetaComposer
{
    public function compose(View $view)
    {
        $page_title = Navigator::get_page_title();
        $view->with(['page_title' => $page_title]);
    }
}
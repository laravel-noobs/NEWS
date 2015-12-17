<?php namespace App\Http\Composers;

use App\Http\Composers\NavigationBuilder\Navigator;
use Illuminate\Contracts\View\View;

class BreadcrumbComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $breadcrumb = Navigator::breadcrumb();
        $view->with('breadcrumb', $breadcrumb['breadcrumb'])
            ->with('page_heading', $breadcrumb['page_heading']);
    }
}
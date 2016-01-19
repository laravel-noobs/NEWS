<?php namespace App\Http\Composers;

use KouTsuneka\Navigation\Navigator;
use Illuminate\Contracts\View\View;

class BreadcrumbComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $has_page_heading = Navigator::has_page_heading();
        $view->with(['has_page_heading' => $has_page_heading]);
        if($has_page_heading)
        {
            $breadcrumb = Navigator::breadcrumb();
            $view->with([
                'breadcrumb' => $breadcrumb['breadcrumb'],
                'page_heading' => $breadcrumb['page_heading']
            ]);
        }
    }
}
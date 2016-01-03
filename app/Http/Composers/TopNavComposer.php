<?php namespace App\Http\Composers;

use App\Http\Composers\NavigationBuilder\Navigator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TopNavComposer
{
    public function compose(View $view)
    {
        $user = Auth::user();
        $authenticated = $user != null;
        $view->with([
            'has_page_heading' => Navigator::has_page_heading(),
            'authenticated' => $authenticated,
        ]);

        if($authenticated)
        {
            $view->with([
                'user_email' => $user->email
            ]);
        }

    }
}
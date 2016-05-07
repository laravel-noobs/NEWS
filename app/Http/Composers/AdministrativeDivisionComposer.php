<?php
/**
 * Created by PhpStorm.
 * User: Tsuneka
 * Date: 01-May-16
 * Time: 13:50
 */

namespace App\Http\Composers;

use KouTsuneka\Navigation\Navigator;
use Illuminate\Contracts\View\View;
use App\Province;

class AdministrativeDivisionComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $provinces = Province::with('type')->get();
        $view->with(['provinces' => $provinces]);
    }
}
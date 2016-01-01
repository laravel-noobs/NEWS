<?php namespace App\Http\Composers\NavigationBuilder;

use URL;

class NavigationBuilder
{
    /**
     * @var string
     */
    private $acronym = 'NEWS';

    /**
     * @var string
     */
    private $page_title = 'NEWS';

    /**
     * @var bool
     */
    private $sort = false;
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $crumbs = [];

    /**
     * @var array
     */
    private $breadcrumb = [];

    /**
     * @var string
     */
    private $page_heading;

    /**
     *
     */
    function __construct() {
        $this->items = array_merge($this->items, include('Templates/NavigationTemplate.php'));
        $this->crumbs = array_merge($this->crumbs, include('Templates/CrumbsTemplate.php'));
    }

    /**
     * @param $name
     * @param $text
     * @param bool|false $active
     * @param null $action
     * @param int $order
     * @param string $icon_class
     * @param null $items
     * @return $this
     */
    public function set($name, $text, $active = false, $action = null, $order = 0, $icon_class = '', $items = null)
    {
        $this->items[$name] = [
            'text' => $text,
            'icon_class' => $icon_class,
            'order' => $order,
            'active' => $active,
            'items' => $items
        ];
        if($action != null)
            $this->items[$name]['action'] = $action;

        return $this;
    }

    /**
     * @param $name
     * @param $sub_name
     * @param $text
     * @param bool|false $active
     * @param int $order
     * @param null $action
     * @return $this
     */
    public function set_sub($name, $sub_name, $text, $active = false, $order = 0, $action = null)
    {
        if(isset($this->items[$name]))
        {
            $this->items[$name]['items'][$sub_name] = [
                'text' => $text,
                'active' => $active,
                'order' => $order
            ];
            if($action != null)
                $this->items[$name]['items'][$sub_name]['action'] = $action;
        }

        return $this;
    }

    /**
     * @param $name
     * @param $sub_name
     * @return $this
     */
    public function activate($name, $sub_name = null)
    {
        if(isset($this->items[$name]))
        {
            $this->items[$name]['active'] = true;
            if(isset($this->items[$name]['items'][$sub_name]))
                $this->items[$name]['items'][$sub_name]['active'] = true;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function breadcrumb()
    {
        if(count($this->breadcrumb) > 0)
            $this->breadcrumb[count($this->breadcrumb)-1]['active'] = true;

        return [
            'page_heading' => $this->page_heading,
            'breadcrumb' => $this->breadcrumb
        ];
    }

    /**
     * @return $this
     */
    public function set_breadcrumb()
    {
        $numargs = func_num_args();
        $args = func_get_args();
        $breadcrumb = [];
        for ($i = 0; $i < $numargs; $i++) {
            if(is_string($args[$i])) {
                if (array_key_exists($args[$i], $this->crumbs))
                    $breadcrumb[] = $this->crumbs[$args[$i]];
                continue;
            }
            if(is_array($args[$i]))
            {
                $val = reset($args[$i]);
                $key = key($args[$i]);
                if (array_key_exists($key, $this->crumbs))
                    $breadcrumb[] = array_merge($this->crumbs[$key], $val);
                else
                    $breadcrumb[$key] = $val;
                continue;
            }
        }
        $this->breadcrumb = $breadcrumb;
        return $this;
    }

    /**
     * @param string $page_heading
     * @return $this
     */
    public function set_page_heading($page_heading)
    {
        $this->page_heading = $page_heading;
        return $this;
    }
    /**
     * @return array
     */
    public function get_navigation()
    {
        return [
            'acronym' => $this->acronym,
            'menu_items' => $this->sort ? $this->reconstruct() : $this->items
        ];
    }

    /**
     * @param $value
     * @return $this
     */
    public function set_sort($value)
    {
        $this->sort = $value;
        return $this;
    }

    public function set_page_title($page_title)
    {
        $this->page_title = $page_title;
    }

    public function get_page_title()
    {
        return $this->page_title;
    }

    /**
     *
     */
    private function reconstruct()
    {
        $items = array_sort($this->items,  function ($value) {
            return $value['order'];
        });
        foreach($items as $key => $it)
        {
            if(!isset($it['items']))
                continue;
            $items[$key]['items'] = array_sort($it['items'], function($value){
                return $value['order'];
            });
        }
        return $items;
    }
}
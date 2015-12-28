<?php namespace App\Http\Composers\NavigationBuilder;

use URL;

class NavigationBuilder
{
    /**
     * @var string
     */
    private $acronym = 'NEWS';

    /**
     * @var bool
     */
    private $sort = false;
    /**
     * @var array
     */
    private $items = [
        'admin' => [
            'text' => 'Bảng điều khiển',
            'active' => false,
            'icon_class' => 'fa fa-th-large',
            'order' => 1
        ],
        'users' => [
            'text' => 'Người dùng',
            'active' => false,
            'icon_class' => 'fa fa-user',
            'items' => [
                'index' => [
                    'text' => 'Tất cả',
                    'active' => false,
                    'action' => 'UsersController@index',
                    'order' => 1
                ],
                'create' => [
                    'text' => 'Thêm mới',
                    'active' => false,
                    'action' => 'UsersController@create',
                    'order' => 2
                ]
            ],
            'order' => 2
        ],
        'posts' => [
            'text' => 'Bài viết',
            'active' => false,
            'icon_class' => 'fa fa-pencil',
            'items' => [
                    'index' => [
                    'text' => 'Tất cả',
                    'active' => false,
                    'order' => 1
                ],
                'create' => [
                    'text' => 'Thêm mới',
                    'active' => false,
                    'order' => 2
                ],
                'categories' => [
                    'text' => 'Chuyên mục',
                    'action' => 'CategoriesController@index',
                    'active' => false,
                    'order' => 3
                ],
                'tags' => [
                    'text' => 'Tags',
                    'active' => false,
                    'order' => 4
                ]
            ],
            'order' => 3
        ],
        'feedbacks' => [
            'text' => 'Phản hồi',
            'active' => false,
            'icon_class' => 'fa fa-send-o',
            'order' => 4
        ],
    ];

    /**
     * @var array
     */
    private $crumbs = [
        'admin' => [
            'text' => 'Bảng điều khiển',
            'icon_class' => 'fa fa-th-large'
        ],
        'users' => [
            'text' => 'Người dùng',
            'icon_class' => 'fa fa-users',
        ],
        'user_create' => [
            'text' => 'Tạo mới',
            'icon_class' => 'fa fa-user-plus',
        ],
        'user_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench',
        ],
        'posts' => [
            'text' => 'Bài viết',
            'icon_class' => 'fa fa-files-o',
        ],
        'post_create' => [
            'text' => 'Tạo mới',
            'icon_class' => 'fa fa-file-text-o',
        ],
        'post_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-edit',
        ],
        'feedbacks' => [
            'text' => 'Phản hồi',
            'icon_class' => 'fa fa-send',
        ],
        'tags' => [
            'text' => 'Tags',
            'icon_class' => 'fa fa-tags',
        ],
        'categories' => [
            'text' => 'Chuyên mục',
            'icon_class' => 'fa fa-archive'
        ],
        'category_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench'
        ],
        'search_result' => [
            'text' => 'Kết quả tìm kiếm',
            'icon_class' => 'fa fa-search',
        ],
    ];

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
        $urls = [
            'admin' => URL::action('AdminController@index'),
            'users' => URL::action('UsersController@index'),
            'user_edit' => URL::action('UsersController@edit'),
            'categories' => URL::action('CategoriesController@index'),
        ];
        foreach($urls as $key => $val)
            if(isset($this->crumbs[$key]))
                $this->crumbs[$key]['url'] = $val;
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
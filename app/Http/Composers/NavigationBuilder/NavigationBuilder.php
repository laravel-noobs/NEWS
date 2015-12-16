<?php namespace App\Http\Composers\NavigationBuilder;


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
                    'order' => 1
                ],
                'create' => [
                    'text' => 'Thêm mới',
                    'active' => false,
                    'order' => 1
                ],
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
            $this->item[$name]['action'] = $action;

        return $this;
    }

    /**
     * @param $name
     * @param $sub_name
     * @param $text
     * @param int $order
     * @param string $action
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
    public function activate($name, $sub_name)
    {
        if(isset($this->items[$name]))
            if(isset($this->items[$name]['items'][$sub_name]))
            {
                $this->items[$name]['active'] = true;
                $this->items[$name]['items'][$sub_name]['active'] = true;
            }

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
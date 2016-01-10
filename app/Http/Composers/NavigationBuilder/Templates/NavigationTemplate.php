<?php
return [
    'admin' => [
        'text' => 'Bảng điều khiển',
        'action' => 'AdminController@index',
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
                'action' => 'UsersController@index',
                'active' => false,
                'order' => 1
            ],
            'create' => [
                'text' => 'Thêm mới',
                'active' => false,
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
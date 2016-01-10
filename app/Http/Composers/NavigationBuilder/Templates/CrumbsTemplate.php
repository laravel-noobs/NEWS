<?php
return [
    'admin' => [
        'text' => 'Bảng điều khiển',
        'icon_class' => 'fa fa-th-large',
        'url' => URL::action('AdminController@index')
    ],
    'users' => [
        'text' => 'Người dùng',
        'icon_class' => 'fa fa-users',
        'url' => URL::action('UsersController@index')
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
        'icon_class' => 'fa fa-archive',
        'url' => URL::action('CategoriesController@index')
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
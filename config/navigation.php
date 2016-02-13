<?php
return [
    'acronym' => 'NEWS',
    'page_title' => 'NEWS',
    'navigation' => [
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
                    'action' => 'PostsController@index',
                    'active' => false,
                    'order' => 1
                ],
                'create' => [
                    'text' => 'Thêm mới',
                    'action' => 'PostsController@create',
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
                    'action' => 'TagsController@index',
                    'active' => false,
                    'order' => 4
                ]
            ],
            'order' => 3
        ],
        'feedbacks' => [
            'text' => 'Phản hồi',
            'action' => 'FeedbacksController@index',
            'active' => false,
            'icon_class' => 'fa fa-send-o',
            'order' => 4
        ],
        'comments' => [
            'text' => 'Bình luận',
            'action' => 'CommentsController@index',
            'active' => false,
            'icon_class' => 'fa fa-comments',
            'order' => 4
        ],
    ],

    /*
     *
     */
    'crumbs' => [
        'admin' => [
            'text' => 'Bảng điều khiển',
            'icon_class' => 'fa fa-th-large',
            'action' => 'AdminController@index'
        ],
        'users' => [
            'text' => 'Người dùng',
            'icon_class' => 'fa fa-users',
            'action' => 'UsersController@index'
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
            'action' => 'PostsController@index'
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
            'action' => 'FeedbacksController@index'
        ],
        'feedbacks_by_post' => [
            'text' => 'Theo người dùng'
        ],
        'feedbacks_by_user' => [
            'text' => 'Theo người dùng'
        ],
        'tags' => [
            'text' => 'Tags',
            'icon_class' => 'fa fa-tags',
            'action' => 'TagsController@index'
        ],
        'tag_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench'
        ],
        'categories' => [
            'text' => 'Chuyên mục',
            'icon_class' => 'fa fa-archive',
            'action' => 'CategoriesController@index'
        ],
        'category_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench'
        ],
        'comments'=> [
            'text' => 'Bình luận',
            'icon_class' => 'fa fa-comments',
            'action' => 'CommentsController@index'
        ],
        'search_result' => [
            'text' => 'Kết quả tìm kiếm',
            'icon_class' => 'fa fa-search',
        ],
    ]
];
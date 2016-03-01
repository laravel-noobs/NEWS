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
        'products' => [
            'text' => 'Sản phẩm',
            'active' => false,
            'icon_class' => 'fa fa-shopping-bag',
            'hidden' => function()
            {
                return Gate::denies('indexProductCategory') && Gate::denies('indexProductBrand');
            },
            'items' => [
                'reviews' => [
                    'text' => 'Đánh giá',
                    'action' => 'ProductReviewsController@index',
                    'active' => false,
                    'order' => 1,
                    'hidden' => function(){
                        return Gate::denies('indexProductReview');
                    }
                ],
                'categories' => [
                    'text' => 'Danh mục',
                    'action' => 'ProductCategoriesController@index',
                    'active' => false,
                    'order' => 2,
                    'hidden' => function(){
                        return Gate::denies('indexProductCategory');
                    }
                ],
                'brands' => [
                    'text' => 'Nhãn hiệu',
                    'action' => 'ProductBrandsController@index',
                    'active' => false,
                    'order' => 3,
                    'hidden' => function(){
                        return Gate::denies('indexProductBrand');
                    }
                ]
            ],
            'order' => 2
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
                    'order' => 1,
                    'hidden' => function(){
                        return Gate::denies('indexUser');
                    }
                ],
                'create' => [
                    'text' => 'Thêm mới',
                    'action'=>'UsersController@create',
                    'active' => false,
                    'order' => 2,
                    'hidden' => function(){
                        return Gate::denies('storeUser');
                    }
                ]
            ],
            'order' => 2
        ],
        'posts' => [
            'text' => 'Bài viết',
            'active' => false,
            'icon_class' => 'fa fa-pencil',
            'items' => [
                'owned' => [
                    'text' => 'Của tôi',
                    'action' => 'PostsController@listByAuthenticated',
                    'active' => false,
                    'order' => 1,
                    'hidden' => function(){
                        return Gate::denies('listOwnedPost');
                    }
                ],
                'index' => [
                    'text' => 'Tất cả',
                    'action' => 'PostsController@index',
                    'active' => false,
                    'order' => 2,
                    'hidden' => function(){
                        return Gate::denies('indexPost');
                    }
                ],
                'create' => [
                    'text' => 'Thêm mới',
                    'action' => 'PostsController@create',
                    'active' => false,
                    'order' => 3,
                    'hidden' => function(){
                        return Gate::denies('storePost') &&
                        Gate::denies('storePendingPost') &&
                        Gate::denies('storeApprovedPost') &&
                        Gate::denies('storeDraftPost') &&
                        Gate::denies('storeTrashPost');
                    }
                ],
                'categories' => [
                    'text' => 'Chuyên mục',
                    'action' => 'CategoriesController@index',
                    'active' => false,
                    'order' => 4,
                    'hidden' => function(){
                        return Gate::denies('indexCategory');
                    }
                ],
                'tags' => [
                    'text' => 'Tags',
                    'action' => 'TagsController@index',
                    'active' => false,
                    'order' => 5,
                    'hidden' => function(){
                        return Gate::denies('indexTag');
                    }
                ]
            ],
            'order' => 3
        ],
        'feedbacks' => [
            'text' => 'Phản hồi',
            'action' => 'FeedbacksController@index',
            'active' => false,
            'icon_class' => 'fa fa-send-o',
            'order' => 4,
            'hidden' => function(){
                return Gate::denies('indexFeedback') && Gate::denies('listOwnedPostFeedback');
            },
            'items' => [
                'index' => [
                    'text' => 'Tất cả',
                    'action' => 'FeedbacksController@index',
                    'active' => false,
                    'order' => 1,
                    'hidden' => function(){
                        return Gate::denies('indexFeedback');
                    }
                ],
                'owned' => [
                    'text' => 'Của bài viết của tôi',
                    'action' => 'FeedbacksController@listByPostAuthenticatedUser',
                    'active' => false,
                    'order' => 2,
                    'hidden' => function(){
                        return Gate::denies('listOwnedPostFeedback');
                    }
                ],
            ]
        ],
        'comments' => [
            'text' => 'Bình luận',
            'action' => 'CommentsController@index',
            'active' => false,
            'icon_class' => 'fa fa-comments',
            'order' => 5,
            'hidden' => function(){
                return Gate::denies('indexComment');
            }
        ],
        'privileges' => [
            'text' => 'Quyền hạn',
            'action' => 'PrivilegesController@index',
            'active' => false,
            'icon_class' => 'fa fa-gavel',
            'order' => 6,
            'hidden' => function(){
                return false;
            }
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
        'product_reviews' => [
            'text' => 'Đánh giá sản phẩm',
            'icon_class' => 'fa fa-star-o',
            'action' => 'ProductReviewsController@index'
        ],
        'product_review_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench'
        ],
        'product_brands' => [
            'text' => 'Nhãn hiệu sản phẩm',
            'icon_class' => 'fa fa-copyright',
            'action' => 'ProductBrandsController@index'
        ],
        'product_brand_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench'
        ],
        'product_categories' => [
            'text' => 'Danh mục sản phẩm',
            'icon_class' => 'fa fa-archive',
            'action' => 'ProductCategoriesController@index'
        ],
        'product_category_edit' => [
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
        'comment_edit' => [
            'text' => 'Sửa',
            'icon_class' => 'fa fa-wrench'
        ],
        'search_result' => [
            'text' => 'Kết quả tìm kiếm',
            'icon_class' => 'fa fa-search',
        ],
        'privileges' => [
            'text' => 'Quyền hạn',
            'icon_class' => 'fa fa-gavel',
        ],
    ]
];
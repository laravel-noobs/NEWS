<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->delete();
        $permissions =
            [
                [
                    'name' => 'grantPermission',
                    'label'=> 'Cấp phép'
                ],
                [
                    'name' => 'accessAdminPanel',
                    'label'=> 'Truy cập trang admin'
                ],
                [
                    'name' => 'indexUser',
                    'label'=> 'Xem danh sách người dùng'
                ],
                [
                    'name' => 'storeUser',
                    'label'=> 'Thêm người dùng'
                ],
                [
                    'name' => 'banUser',
                    'label'=> 'Khóa người dùng'
                ],
                [
                    'name' => 'updateUser',
                    'label'=> 'Cập nhật người dùng'
                ],
                [
                    'name' => 'queryUser',
                    'label'=> 'Truy vấn người dùng'
                ],
                [
                    'name' => 'destroyUser',
                    'label'=> 'Xóa người dùng'
                ],
                [
                    'name' => 'indexPost',
                    'label'=> 'Xem danh sách tất cả các bài viết'
                ],
                [
                    'name' => 'listOwnedPost',
                    'label'=> 'Xem danh sách bài viết của bản thân'
                ],
                [
                    'name' => 'storePendingPost',
                    'label'=> 'Thêm bài viết ở trạng thái đợi duyệt'
                ],
                [
                    'name' => 'storeApprovedPost',
                    'label'=> 'Thêm bài viết ở trạng thái đã duyệt'
                ],
                [
                    'name' => 'storeTrashPost',
                    'label'=> 'Thêm bài viết ở trạng thái trong thùng rác'
                ],
                [
                    'name' => 'storeDraftPost',
                    'label'=> 'Thêm bài viết ở trạng thái nháp'
                ],
                [
                    'name' => 'storePostWithNewCategory',
                    'label'=> 'Thêm chuyên mục mới khi thêm post'
                ],
                [
                    'name' => 'storePostWithNewTag',
                    'label'=> 'Thêm tag mới khi thêm post'
                ],
                [
                    'name' => 'updatePostStatus',
                    'label'=> 'Cập nhật trạng thái bài viết'
                ],
                [
                    'name' => 'approvePost',
                    'label'=> 'Duyệt bất kỳ bài viết'
                ],
                [
                    'name' => 'approveDraftPost',
                    'label'=> 'Duyệt bài viết nháp bất kỳ'
                ],
                [
                    'name' => 'approveOwnedDraftPost',
                    'label'=> 'Duyệt bài viết nháp của bản thân'
                ],
                [
                    'name' => 'approvePendingPost',
                    'label'=> 'Duyệt bài viết đợi duyệt bất kỳ'
                ],
                [
                    'name' => 'approveOwnedPendingPost',
                    'label'=> 'Duyệt bài viết đợi duyệt của bản thân'
                ],
                [
                    'name' => 'approveCollaboratorPost',
                    'label'=> 'Duyệt bài viết bất kỳ của cộng tác viên'
                ],
                [
                    'name' => 'approveCollaboratorDraftPost',
                    'label'=> 'Duyệt bài viết nháp của cộng tác viên'
                ],
                [
                    'name' => 'approveCollaboratorPendingPost',
                    'label'=> 'Duyệt bài viết đang chờ duyệt của cộng tác viên'
                ],
                [
                    'name' => 'unapprovePost',
                    'label'=> 'Bỏ duyệt bài viết'
                ],
                [
                    'name' => 'destroyPost',
                    'label'=> 'Xóa bài viết'
                ],
                [
                    'name' => 'trashPost',
                    'label'=> 'Cho bài viết vào thùng rác'
                ],
                [
                    'name' => 'trashOwnedPost',
                    'label'=> 'Cho bài viết của bản thân vào thùng rác'
                ],
                [
                    'name' => 'updatePost',
                    'label'=> 'Cập nhật bài viết'
                ],
                [
                    'name' => 'updatePostWithNewCategory',
                    'label'=> 'Thêm chuyên mục mới khi sửa post'
                ],
                [
                    'name' => 'updatePostWithNewTag',
                    'label'=> 'Thêm tag mới khi sửa post'
                ],
                [
                    'name' => 'updateOwnedPost',
                    'label'=> 'Cập nhật bài viết của bản thâm'
                ],
                [
                    'name' => 'indexCategory',
                    'label'=> 'Xem danh sách chuyên mục'
                ],
                [
                    'name' => 'storeCategory',
                    'label'=> 'Thêm chuyên mục mới'
                ],
                [
                    'name' => 'updateCategory',
                    'label'=> 'Cập nhật chuyên mục bất kỳ'
                ],
                [
                    'name' => 'destroyCategory',
                    'label'=> 'Xóa chuyên mục'
                ],
                [
                    'name' => 'indexFeedback',
                    'label'=> 'Xem danh sách phản hồi'
                ],
                [
                    'name' => 'checkFeedback',
                    'label'=> 'Duyệt phản hồi'
                ],
                [
                    'name' => 'indexTag',
                    'label'=> 'Xem danh sách tag'
                ],
                [
                    'name' => 'queryTag',
                    'label'=> 'Truy vấn danh sách tag'
                ],
                [
                    'name' => 'storeTag',
                    'label'=> 'Thêm mới tag'
                ],
                [
                    'name' => 'updateTag',
                    'label'=> 'Sửa tag'
                ],
                [
                    'name' => 'destroyTag',
                    'label'=> 'Xóa tag'
                ],
                [
                    'name' => 'indexComment',
                    'label'=> 'Xem danh sách bình luận'
                ],
                [
                    'name' => 'updateComment',
                    'label'=> 'Sửa bình luận'
                ],
                [
                    'name' => 'spamComment',
                    'label'=> 'Đánh dấu spam bình luận'
                ],
                [
                    'name' => 'unspamComment',
                    'label'=> 'Bỏ đánh dấu spam bình luận'
                ],
                [
                    'name' => 'approveComment',
                    'label'=> 'Duyệt bình luận'
                ],
                [
                    'name' => 'approveOwnedPostComment',
                    'label'=> 'Duyệt bình luận'
                ],
                [
                    'name' => 'unapproveComment',
                    'label'=> 'Bỏ duyệt bình luận'
                ],
                [
                    'name' => 'trashComment',
                    'label'=> 'Cho bình luận vào thùng rác'
                ],
                [
                    'name' => 'trashOwnedPostComment',
                    'label'=> 'Duyệt bình luận'
                ],
                [
                    'name' => 'destroyComment',
                    'label'=> 'Xóa bình luận'
                ],


                [
                    'name' => 'indexProductCategory',
                    'label'=> 'Xem danh sách danh mục sản phẩm'
                ],
                [
                    'name' => 'storeProductCategory',
                    'label'=> 'Thêm danh mục sản phẩm'
                ],
                [
                    'name' => 'updateProductCategory',
                    'label'=> 'Thêm danh mục sản phẩm'
                ],
                [
                    'name' => 'destroyProductCategory',
                    'label'=> 'Xóa danh mục sản phẩm'
                ],

                [
                    'name' => 'indexProductBrand',
                    'label'=> 'Xem danh sách nhãn hiệu sản phẩm'
                ],
                [
                    'name' => 'storeProductBrand',
                    'label'=> 'Thêm nhãn hiệu sản phẩm'
                ],
                [
                    'name' => 'updateProductBrand',
                    'label'=> 'Thêm nhãn hiệu sản phẩm'
                ],
                [
                    'name' => 'destroyProductBrand',
                    'label'=> 'Xóa nhãn hiệu sản phẩm'
                ],
                [
                    'name' => 'indexProductReview',
                    'label' => 'Xem đánh giá sản phẩm'
                ],
                [
                    'name' => 'updateProductReview',
                    'label' => 'Sửa đánh giá sản phẩm'
                ],
                [
                    'name' => 'checkProductReview',
                    'label' => 'Duyệt đánh giá sản phẩm'
                ],
                [
                    'name' => 'destroyProductReview',
                    'label' => 'Xóa đánh giá sản phẩm'
                ],

                [
                    'name' => 'indexProduct',
                    'label' => 'Xem danh sách sản phẩm'
                ],
                [
                    'name' => 'updateProduct',
                    'label' => 'Sửa sản phẩm'
                ],
                [
                    'name' => 'disableProduct',
                    'label' => 'Vô hiệu sản phẩm'
                ],
                [
                    'name' => 'enableProduct',
                    'label' => 'Cho phép sản phẩm'
                ],
                [
                    'name' => 'destroyProduct',
                    'label' => 'Xóa sản phẩm'
                ],
                [
                    'name' => 'indexCollection',
                    'label' => 'Xem danh sách nhóm sản phẩm'
                ],
                [
                    'name' => 'storeCollection',
                    'label' => 'Thêm nhóm sản phẩm'
                ],
                [
                    'name' => 'updateCollection',
                    'label' => 'Sửa danh sách sản phẩm'
                ],
                [
                    'name' => 'destroyCollection',
                    'label' => 'Xóa danh sách sản phẩm'
                ]
            ];
        DB::table('permission')->insert($permissions);
    }
}

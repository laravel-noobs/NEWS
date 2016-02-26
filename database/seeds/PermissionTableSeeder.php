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
                    'name' => 'accessAdminPanel',
                    'label'=> 'Truy cập trang admin',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'indexUser',
                    'label'=> 'Xem danh sách người dùng',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'configUser',
                    'label'=> 'Cấu hình cho UserController',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'storeUser',
                    'label'=> 'Thêm người dùng',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'banUser',
                    'label'=> 'Khóa người dùng',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updateUser',
                    'label'=> 'Cập nhật người dùng',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'queryUser',
                    'label'=> 'Truy vấn người dùng',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'destroyUser',
                    'label'=> 'Xóa người dùng',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'indexPost',
                    'label'=> 'Xem danh sách tất cả các bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'listOwnedPost',
                    'label'=> 'Xem danh sách bài viết người đăng nhập',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'storePendingPost',
                    'label'=> 'Thêm bài viết ở trạng thái đợi duyệt',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'storeApprovedPost',
                    'label'=> 'Thêm bài viết ở trạng thái đã duyệt',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'storeTrashPost',
                    'label'=> 'Thêm bài viết ở trạng thái đã duyệt',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'storeDraftPost',
                    'label'=> 'Thêm bài viết ở trạng thái nháp',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'storePostWithNewCategory',
                    'label'=> 'Thêm category mới khi thêm post',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'storePostWithNewTag',
                    'label'=> 'Thêm tag mới khi thêm post',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updatePostStatus',
                    'label'=> 'Cập nhật trạng thái bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'approvePost',
                    'label'=> 'Duyệt bất kỳ bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'approveDraftPost',
                    'label'=> 'Duyệt bài viết nháp của bản thân',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'approveOwnedDraftPost',
                    'label'=> 'Duyệt bài viết nháp của bản thân',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'approvePendingPost',
                    'label'=> 'Duyệt bài viết đợi duyệt bất kỳ',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'approveOwnedPendingPost',
                    'label'=> 'Duyệt bài viết đợi duyệt của bản thân',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'approveCollaboratorPost',
                    'label'=> 'Duyệt bài viết bất kỳ của cộng tác viên',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'approveCollaboratorDraftPost',
                    'label'=> 'Duyệt bài viết nháp của cộng tác viên',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'approveCollaboratorPendingPost',
                    'label'=> 'Duyệt bài viết đang chờ duyệt của cộng tác viên',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'unapprovePost',
                    'label'=> 'Bỏ duyệt bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'destroyPost',
                    'label'=> 'Xóa bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'trashPost',
                    'label'=> 'Cho bài viết vào thùng rác',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'trashOwnedPost',
                    'label'=> 'Cho bài viết của bản thân vào thùng rác',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'updatePost',
                    'label'=> 'Cập nhật bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updatePostWithNewCategory',
                    'label'=> 'Thêm category mới khi sửa post',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updatePostWithNewTag',
                    'label'=> 'Thêm tag mới khi sửa post',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updateOwnedPost',
                    'label'=> 'Cập nhật bài viết của ',
                    'model' => 'App\Post',
                    'policy' => 'App\Policies\PostPolicy'
                ],
                [
                    'name' => 'indexCategory',
                    'label'=> 'Xem danh sách chuyên mục',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'storeCategory',
                    'label'=> 'Thêm bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updateCategory',
                    'label'=> 'Cập nhật bài viết bất kỳ',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'destroyCategory',
                    'label'=> 'Xóa bài viết',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'indexFeedback',
                    'label'=> 'Xem danh sách phản hồi',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'listOwnedPostFeedback',
                    'label'=> 'Xem danh sách phản hồi của bài viết của tôi',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'checkFeedback',
                    'label'=> 'Duyệt phản hồi',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'checkOwnedPostFeedback',
                    'label'=> 'Duyệt phản hồi của bài viết của tôi',
                    'model' => 'App\Feedback',
                    'policy' => 'App\Policies\FeedbackPolicy'
                ],
                [
                    'name' => 'indexTag',
                    'label'=> 'Xem danh sách tag',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'queryTag',
                    'label'=> 'Truy vấn danh sách tag',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'storeTag',
                    'label'=> 'Thêm mới tag',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updateTag',
                    'label'=> 'Sửa tag',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'destroyTag',
                    'label'=> 'Xóa tag',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'indexComment',
                    'label'=> 'Xem danh sách bình luận',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'updateComment',
                    'label'=> 'Sửa bình luận',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'spamComment',
                    'label'=> 'Đánh dấu spam bình luận',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'unspamComment',
                    'label'=> 'Bỏ đánh dấu spam bình luận',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'approveComment',
                    'label'=> 'Duyệt bình luận',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'unapproveComment',
                    'label'=> 'Bỏ duyệt bình luận',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'trashComment',
                    'label'=> 'Cho bình luận vào thùng rác',
                    'model' => null,
                    'policy' => null
                ],
                [
                    'name' => 'destroyComment',
                    'label'=> 'Xóa bình luận',
                    'model' => null,
                    'policy' => null
                ],
            ];
        DB::table('permission')->insert($permissions);
    }
}

<?php
app('navigator')
        ->activate('posts', 'index')
        ->set_page_heading('Danh sách bài viết')
        ->set_breadcrumb('admin', 'posts');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách bài viết</h5>

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="{{ $posts->perPage() }}">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" data-toggle="true" width="50%">Tiêu đề</th>
                            <th data-sort-ignore="true" data-hide="all">Tác giả</th>
                            <th data-sort-ignore="true">Chuyên mục</th>
                            <th data-hide="all">Ngày đăng</th>
                            <th data-sort-ignore="true">Tình trạng</th>
                            <th data-sort-ignore="true">Lượt xem</th>
                            <th data-sort-ignore="true">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->category != null ? $post->category->name : '' }}</td>
                                <td>{{ $post->published_at }}</td>
                                <td>{{ $post->postStatus->name }}</td>
                                <td>{{ $post->view }}</td>
                                <td>
                                    <div class="btn-group pull-right">
                                        @if($post->postStatus->id != 4)
                                            <a href="#" target="_blank" class="btn-white btn btn-xs">Rác</a>
                                        @endif
                                        <a href="#"  class="btn-white btn btn-xs">Sửa</a>
                                        <a data-toggle="modal" href="#modal-post-delete-prompt" data-post_title="{{ $post->title }}" data-post_id="{{ $post->id }}" class="btn-white btn btn-xs">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pull-right">{!! $posts->links() !!}</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section('post-delete_inputs')
        <input name="post_id" type="hidden"/>
    @endsection
    @include('admin.partials._prompt',
        [
            'id' => 'post-delete',
            'method' => 'post',
            'action' => URL::action('PostsController@destroy'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn xóa bài viết "<span class="post_title">này</span>" hay không?',
        ])
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });

        $('#modal-post-delete-prompt').on('show.bs.modal', function(e) {
            post_id = $(e.relatedTarget).data('post_id');
            post_title = $(e.relatedTarget).data('post_title');
            $(e.currentTarget).find('input[name="post_id"]').val(post_id);
            $(e.currentTarget).find('span.post_title').text(post_title);
        });
    </script>
@endsection


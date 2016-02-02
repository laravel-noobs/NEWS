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

                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                        <thead>
                        <tr>

                            <th data-toggle="true">Tiêu đề</th>
                            <th data-hide="all">Tác giả</th>
                            <th>Chuyên mục</th>
                            <th data-hide="all">Ngày đăng</th>
                            <th>Tình trạng</th>
                            <th>Lượt xem</th>
                            <th>Hành động</th>
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
                                        <a href="#"  class="btn-white btn btn-xs">Sửa</a>
                                        <a href="#" target="_blank" class="btn-white btn btn-xs">Xem</a>
                                        <a href="#" class="btn-white btn btn-xs">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
    </script>
@endsection
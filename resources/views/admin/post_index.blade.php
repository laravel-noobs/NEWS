<?php
app('navigator')
        ->activate('posts', 'index')
        ->set_page_heading('Danh sách bài viết')
        ->set_breadcrumb('admin', 'posts');
?>

@extends('partials.admin._layout')

@section('post-delete_inputs')
    <input name="post_id" type="hidden"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group search-box">
                                <input placeholder="Tìm bài viết" id="search-input" type="text" class="form-control input-sm" value="{{ $filter_search_term }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn-white btn btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="category_id" name="category_id" class="category form-control">
                                <option value="*">Tất cả chuyên mục</option>
                                @foreach($categories as $cat)
                                    @if($filter_category == $cat['id'])
                                        <option value="{{ $cat['id'] }}" selected="selected">{{ $cat['name'] }}</option>
                                    @else
                                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'pending' ? 'checked' : '' }} value="pending"> Đợi duyệt
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'approved' ? 'checked' : '' }} value="approved"> Đã duyệt
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'draft' ? 'checked' : '' }} value="draft"> Nháp
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'trash' ? 'checked' : '' }} value="trash"> Rác
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                            <th data-sort-ignore="true"><span class="pull-right">Hành động</span></th>
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

        $(".category").select2({
            placeholder: "Lọc theo chuyên mục",
            tags: true
        });

        $('#modal-post-delete-prompt').on('show.bs.modal', function(e) {
            post_id = $(e.relatedTarget).data('post_id');
            post_title = $(e.relatedTarget).data('post_title');
            $(e.currentTarget).find('input[name="post_id"]').val(post_id);
            $(e.currentTarget).find('span.post_title').text(post_title);
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-gree',
            radioClass: 'iradio_square-green'
        });

        $('input[name="status_type"]').on('ifChecked', function(event){
            $.ajax({
                url: location.pathname + '/config',
                method: 'post',
                data: { name: "filter.status_type", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('select[name="category_id"]').on("select2:select", function (e) {
            cat_id = $(e.currentTarget).val();
            $.ajax({
                url: location.pathname + '/config',
                method: 'post',
                data: { name: "filter.category", value: cat_id === '*' ? 'NULL' : cat_id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('.search-box button').on('click', function(){
            box = $(this).parents('.search-box');
            $.ajax({
                url: location.pathname + '/config',
                method: 'post',
                data: { name: "filter.search_term", value: box.find('#search-input').val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>
@endsection


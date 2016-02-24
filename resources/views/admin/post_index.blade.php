<?php
if(isset($user))
    app('navigator')
            ->activate('posts', 'owned')
            ->set_page_heading('Danh sách bài viết của ' . $user->name)
            ->set_breadcrumb('admin', 'posts');
else
    app('navigator')
            ->activate('posts', 'index')
            ->set_page_heading('Danh sách bài viết')
            ->set_breadcrumb('admin', 'posts');
?>

@extends('partials.admin._layout')

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
                            <th data-sort-ignore="true" data-toggle="true" width="40%">Tiêu đề</th>
                            <th data-sort-ignore="true">Tác giả</th>
                            <th data-sort-ignore="true">Chuyên mục</th>
                            <th data-sort-ignore="true" data-hide="phone">Phản hồi</th>
                            <th data-sort-ignore="true" data-hide="phone">Bình luận</th>
                            <th data-sort-ignore="true">Lượt xem</th>
                            <th data-sort-ignore="true" data-hide="phone">Ngày đăng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>
                                    <strong>{{ $post->title }}</strong>
                                    <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                        @if(Gate::allows('approvePost') ||
                                            Gate::allows('approveDraftPost', $post) ||
                                            Gate::allows('approveOwnDraftPost', $post) ||
                                            Gate::allows('approvePendingPost', $post) ||
                                            Gate::allows('approveOwnPendingPost', $post) ||
                                            Gate::allows('approveCollaboratorPost', $post) ||
                                            Gate::allows('approveCollaboratorDraftPost', $post) ||
                                            Gate::allows('approveCollaboratorPendingPost', $post))
                                            @if($filter_status_type == 'pending' || $filter_status_type == 'draft')
                                                <li class=""><a href="{{ URL::action('PostsController@approve', ['id' => $post->id]) }}" class="text-success">Duyệt</a></li>
                                                <li style="padding: 0px">|</li>
                                            @endif
                                        @endif
                                        @can('unapprovePost')
                                            @if($filter_status_type == 'approved'  || $filter_status_type == 'draft')
                                                <li class=""><a href="{{ URL::action('PostsController@unapprove', ['id' => $post->id]) }}" class="text-success">Bỏ duyệt</a></li>
                                                <li style="padding: 0px">|</li>
                                            @endif
                                        @endcan

                                        @if($filter_status_type == 'trash')
                                            @can('destroyPost')
                                            <li class="pull-right"><a data-toggle="modal" href="#modal-post-delete-prompt" data-post_title="{{ $post->title }}" data-post_id="{{ $post->id }}" class="text-danger">Xóa</a></li>
                                            <li class="pull-right" style="padding: 0px">|</li>
                                            @endcan
                                        @else
                                            @if(Gate::allows('trashPost') || Gate::allows('trashOwnPost', $post))
                                                <li class=""><a href="{{ URL::action('PostsController@trash', ['id' => $post->id]) }}" class="text-danger">Rác</a></li>
                                            @endif
                                        @endif

                                        @if(Gate::allows('updatePost') || Gate::allows('updateOwnPost', $post))
                                            <li class="pull-right"><a href="{{ URL::action('PostsController@edit', ['id' => $post->id]) }}">Sửa</a></li>
                                        @endif
                                    </ul>
                                </td>
                                <td>{{ $post->user->role->label }} - {{ $post->user->name }}</td>
                                <td>{{ $post->category != null ? $post->category->name : '' }}</td>
                                <td>
                                    @can('indexFeedback')
                                        <a href="{{ URL::action('FeedbacksController@listByPost', ['id' => $post->id]) }}"><span>{{ $post->feedbacksCount }}</span></a>
                                    @else
                                        <span>{{ $post->feedbacksCount }}</span>
                                    @endcan
                                </td>
                                <td>{{ $post->commentsCount }}</td>
                                <td>{{ $post->view }}</td>
                                <td>{{ $post->published_at }}</td>
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
    @can('destroyPost')
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
    @endcan
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
                url: '{{ URL::action('PostsController@postConfig') }}',
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
                url: '{{ URL::action('PostsController@postConfig') }}',
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
                url: '{{ URL::action('PostsController@postConfig') }}',
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


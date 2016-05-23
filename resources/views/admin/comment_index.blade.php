<?php
app('navigator')
        ->activate('comments', 'index')
        ->set_page_heading('Danh sách bình luận')
        ->set_breadcrumb('admin', 'comments')
        ->set_page_title('Danh sách bình luận');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-4 b-r">
                            <div class="input-group search-box">
                                <input placeholder="Tìm bình luận" id="search-input" type="text" class="form-control input-sm" value="{{ $filter_search_term }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn-white btn btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3 b-r">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="commentable_type" {{ $filter_commentable_type == 'post' ? 'checked' : '' }} value="post"> Bài viết
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="commentable_type" {{  $filter_commentable_type == 'product' ? 'checked' : '' }} value="product"> Sản phẩm
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:4px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'pending' ? 'checked' : '' }} value="pending"> Đợi duyệt
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:4px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'approved' ? 'checked' : '' }} value="approved"> Đã duyệt
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group b-r" style="margin-right:12px; padding-right: 12px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'trash' ? 'checked' : '' }} value="trash"> Rác
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:4px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="checkbox" name="hide_spam" {{ $filter_hide_spam ? 'checked' : '' }}> Ẩn spam
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
                    <h5>Danh sách bình luận</h5>
                    <span class="text-muted small pull-right">{{ $comments->total() }} bình luận</span>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-page-navigation=".footable-pagination">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" data-hide="phone">Người dùng</th>
                            <th data-sort-ignore="true" width="40%">Nội dung</th>
                            <th data-sort-ignore="true" data-hide="phone" width="20%">
                                @if($filter_commentable_type == 'post')
                                    Bài viết
                                @elseif($filter_commentable_type == 'product')
                                    Sản phẩm
                                @endif

                            </th>
                            <th data-sort-ignore="true" data-hide="phone">Ngày nhận</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)
                            <tr  class="{{ $comment->spam ? 'warning' : '' }}">
                                <td>
                                    @if($comment->user)
                                    <a>
                                        {{ $comment->user->name }}
                                    </a>
                                    @else
                                        <div>{{ $comment->name }}</div>
                                        <a href="mailto:{{ $comment->email }}" target="_top">{{ $comment->email }}</a>
                                    @endif
                                </td>
                                <td>
                                    {{ $comment->content }}
                                    <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                        @if($filter_status_type == 'pending')
                                            @can('approveComment')
                                            <li><a href="{{ URL::action('CommentsController@approve', ['id' => $comment->id]) }}" class="text-success">Duyệt</a></li>
                                            <li style="padding: 0px">|</li>
                                            @endcan
                                        @elseif($filter_status_type == 'approved')
                                            @can('unapproveComment')
                                            <li><a href="{{ URL::action('CommentsController@unapprove', ['id' => $comment->id]) }}" class="text-success">Bỏ duyệt</a></li>
                                            <li style="padding: 0px">|</li>
                                            @endcan
                                        @endif
                                        <li>
                                        @if($comment->spam)
                                            @can('unspamComment')
                                                <a href="{{ URL::action('CommentsController@notspam', ['id' => $comment->id]) }}" class="text-info">Không phải spam</a>
                                            @endcan
                                        @else
                                            @can('spamComment')
                                            <a href="{{ URL::action('CommentsController@spam', ['id' => $comment->id]) }}" class="text-warning">Spam</a>
                                            @endcan
                                        @endif
                                        </li>
                                        @if($filter_status_type == 'trash')
                                            @can('destroyComment')
                                            <li class="pull-right"><a href="{{ URL::action('CommentsController@destroy', ['id' => $comment->id]) }}" class="text-danger">Xóa</a></li>
                                            <li class="pull-right" style="padding: 0px">|</li>
                                            @endcan
                                        @else
                                            @can('trashComment')
                                            <li style="padding: 0px">|</li>
                                            <li><a href="{{ URL::action('CommentsController@trash', ['id' => $comment->id]) }}" class="text-danger">Rác</a></li>
                                            @endcan
                                        @endif
                                        @can('updateComment')
                                            <li class="pull-right"><a href="{{ URL::action('CommentsController@edit', ['id' => $comment->id]) }}">Sửa</a></li>
                                        @endcan
                                    </ul>
                                </td>
                                <td>
                                    @if($filter_commentable_type == 'post')
                                        <a href="{{ URL::action('PostsController@show', ['id' => $comment->commentable->id]) }}">{{$comment->commentable->title}}</a>
                                    @elseif($filter_commentable_type == 'product')
                                        <a href="{{ URL::action('ProductsController@show', ['slug' => $comment->commentable->slug]) }}">{{ $comment->commentable->name }}</a>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pull-right">{!! $comments->links() !!}</div>
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

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $('input[name="hide_spam"]').on('ifToggled', function(event){
            $.ajax({
                url: location.pathname + '/config',
                method: 'post',
                data: { name: "filter.hide_spam", value: $(this).attr('checked') == 'checked' ? 0 : 1 },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
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

        $('a.action').on('click', function(){
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

        $('input[name="commentable_type"]').on('ifChecked', function(event){
            $.ajax({
                url: '{{ URL::action('CommentsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.commentable_type", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>
@endsection
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
                        <div class="col-md-8">
                            <div class="input-group search-box">
                                <input placeholder="Tìm bình luận" id="search-input" type="text" class="form-control input-sm" value="{{ $filter_search_term }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn-white btn btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <div class="form-group" style="margin-right:4px">
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
                            <th data-sort-ignore="true" data-hide="phone" width="20%">Bài viết</th>
                            <th data-sort-ignore="true" data-hide="phone">Ngày nhận</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td>
                                    @if($comment->user)
                                    <a href="{{ URL::action('CommentsController@index', ['id' => $comment->user->id]) }}">
                                        {{ $comment->user->name }}
                                    </a>
                                    @else
                                        <div>{{ $comment->name }}</div>
                                        <a href="mailto:{{ $comment->email }}" target="_top">{{ $comment->email }}</a>
                                    @endif
                                </td>
                                <td>
                                    {{ $comment->content }}
                                    <ul class="list-inline" style="padding-top: 5px; margin-bottom: 0px;">
                                        @if($filter_status_type == 'pending')
                                            <li><a href="{{ URL::action('CommentsController@approve', ['id' => $comment->id]) }}" class="text-success">Duyệt</a></li>
                                            <li style="padding: 0px">|</li>
                                        @elseif($filter_status_type == 'approved')
                                            <li><a href="{{ URL::action('CommentsController@unapprove', ['id' => $comment->id]) }}" class="text-success">Bỏ duyệt</a></li>
                                            <li style="padding: 0px">|</li>
                                        @endif
                                        <li>
                                        @if($comment->spam)
                                            <a href="{{ URL::action('CommentsController@notspam', ['id' => $comment->id]) }}" class="text-info">Không phải spam</a>
                                        @else
                                            <a href="{{ URL::action('CommentsController@spam', ['id' => $comment->id]) }}" class="text-warning">Spam</a>
                                        @endif
                                        </li>
                                        @if($filter_status_type == 'trash')
                                            <li class="pull-right"><a href="{{ URL::action('CommentsController@delete', ['id' => $comment->id]) }}" class="text-danger">Xóa</a></li>
                                            <li class="pull-right" style="padding: 0px">|</li>
                                        @else
                                            <li style="padding: 0px">|</li>
                                            <li><a href="{{ URL::action('CommentsController@trash', ['id' => $comment->id]) }}" class="text-danger">Rác</a></li>
                                        @endif
                                        <li class="pull-right"><a href="{{ URL::action('CommentsController@edit', ['id' => $comment->id]) }}">Sửa</a></li>
                                    </ul>
                                </td>
                                <td><a href="{{ URL::action('FeedbacksController@listByPost', ['id' => $comment->post->id]) }}">{{$comment->post->title}}</a></td>
                                <td>{{ $comment->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="{{ $filter_hide_spam ? 5 : 6 }}">
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
    </script>
@endsection
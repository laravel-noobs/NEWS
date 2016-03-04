<?php
if(isset($owned_post_user))
    app('navigator')
        ->activate('feedbacks', 'owned')
        ->set_page_heading('Danh sách phản hồi của bài viết của ' . $owned_post_user->name)
        ->set_breadcrumb('admin', 'feedbacks')
        ->set_page_title('Danh sách phản hồi của bài viết của ' . $owned_post_user->name);
else
    app('navigator')
        ->activate('feedbacks', 'index')
        ->set_page_heading('Danh sách phản hồi')
        ->set_breadcrumb('admin', 'feedbacks')
        ->set_page_title('Danh sách phản hồi');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="feedbackable_type" {{ $filter_feedbackable_type == 'post' ? 'checked' : '' }} value="post"> Bài viết
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="feedbackable_type" {{  $filter_feedbackable_type == 'product' ? 'checked' : '' }} value="product"> Sản phẩm
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="checkbox" name="show_checked" {{ $filter_show_checked ? 'checked' : '' }}> Đã duyệt
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">

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
                    <h5>Danh sách phản hồi</h5>
                    <span class="text-muted small pull-right">{{ $feedbacks->total() }} phản hồi</span>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-page-navigation=".footable-pagination">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true">Người dùng</th>
                            <th data-sort-ignore="true" width="40%">Nội dung</th>
                            @if($filter_feedbackable_type == 'post')
                                <th data-sort-ignore="true" width="20%">Bài viết</th>
                            @elseif($filter_feedbackable_type == 'product')
                                <th data-sort-ignore="true" width="20%">Sản phẩm</th>
                            @endif

                            <th data-sort-ignore="true">Ngày nhận</th>
                            <th data-sort-ignore="true">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbacks as $feedback)
                            <tr>
                                <td><a href="{{ URL::action('FeedbacksController@listByUser', ['id' => $feedback->user->id]) }}">{{ $feedback->user->name }}</a></td>
                                <td>{{ $feedback->content }}</td>

                                @if($filter_feedbackable_type == 'post')
                                    <td><a href="{{ URL::action('FeedbacksController@listByPost', ['id' => $feedback->feedbackable->id]) }}">{{$feedback->feedbackable->title}}</a></td>
                                @elseif($filter_feedbackable_type == 'product')
                                    <td><a>{{$feedback->feedbackable->name}}</a></td>
                                @endif

                                <td>{{ $feedback->created_at }}</td>
                                <td>
                                    <div class="pull-right">
                                    @if(Gate::allows('checkFeedback') || Gate::allows('checkOwnedPostFeedback', $feedback))
                                        <a  href="#modal-feedback-check-prompt" data-user_email="{{ $feedback->user->email }}" data-feedback_id="{{ $feedback->id }}" class="btn-white btn btn-xs" data-toggle="modal">
                                            <i class="fa {{ $feedback->checked ? "fa-check-square-o" : "fa-square-o" }}"></i>
                                            <span> Phản hồi</span>
                                        </a>
                                    @else
                                        @if($feedback->checked)
                                            <i class="fa fa-check-square-o"></i><span> Đã duyệt</span>
                                        @else
                                            <i class="fa fa-square-o"></i><span> Chưa duyệt</span>
                                        @endif
                                    @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pull-right">{!! $feedbacks->links() !!}</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials._prompt_feedback_check')

@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });
        $('input[name="show_checked"]').on('ifToggled', function(event){
            $.ajax({
                url: '{{ URL::action('FeedbacksController@postConfig') }}',
                method: 'post',
                data: { name: "filter.show_checked", value: $(this).attr('checked') == 'checked' ? 0 : 1 },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
        $('input[name="feedbackable_type"]').on('ifChecked', function(event){
            $.ajax({
                url: '{{ URL::action('FeedbacksController@postConfig') }}',
                method: 'post',
                data: { name: "filter.feedbackable_type", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>
@endsection
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
                            <th data-sort-ignore="true" width="20%">Bài viết</th>
                            <th data-sort-ignore="true">Ngày nhận</th>
                            <th data-sort-ignore="true">
                                <div class="i-checks pull-right">
                                    <label>
                                        <input type="checkbox" name="show_checked" {{ $filter_show_checked ? 'checked' : '' }}> Đã xem
                                    </label>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feedbacks as $feedback)
                            <tr>
                                <td><a href="{{ URL::action('FeedbacksController@listByUser', ['id' => $feedback->user->id]) }}">{{ $feedback->user->name }}</a></td>
                                <td>{{ $feedback->content }}</td>
                                <td><a href="{{ URL::action('FeedbacksController@listByPost', ['id' => $feedback->post->id]) }}">{{$feedback->post->title}}</a></td>
                                <td>{{ $feedback->created_at }}</td>
                                <td>
                                    <div class="pull-right">
                                    @can('checkFeedback')
                                        <a  href="#modal-feedback-check-prompt" data-user_email="{{ $feedback->user->email }}" data-feedback_id="{{ $feedback->id }}"class="btn-white btn btn-xs" data-toggle="modal">
                                            <i class="fa {{ $feedback->checked ? "fa-check-square-o" : "fa-square-o" }}"></i>
                                            <span> Phản hồi</span>
                                        </a>
                                    @else
                                        @if($feedback->checked)
                                            <i class="fa fa-check-square-o"></i><span> Đã duyệt</span>
                                        @else
                                            <i class="fa fa-square-o"></i><span> Chưa duyệt</span>
                                        @endif
                                    @endcan
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
    @can('checkFeedback')
        @include('admin.partials._prompt_feedback_check')
    @endcan
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
            $('input').on('ifToggled', function(event){
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
        });
    </script>
@endsection
<?php
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

                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-page-navigation=".footable-pagination">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" width="40%">Nội dung</th>
                            <th data-sort-ignore="true" width="20%">Bài viết</th>
                            <th data-sort-ignore="true">Người dùng</th>
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
                                <td>{{ $feedback->content }}</td>
                                <td>{{ $feedback->post->title }}</td>
                                <td>{{ $feedback->user->name }}</td>
                                <td>{{ $feedback->created_at }}</td>
                                <td>
                                    <div class="pull-right">
                                        <a data-user_email="{{ $feedback->user->email }}" data-feedback_id="{{ $feedback->id }}"class="btn-white btn btn-xs" data-toggle="modal" href="#modal-feedback-prompt">
                                            <i class="fa {{ $feedback->checked ? "fa-check-square-o" : "fa-square-o" }}"></i>
                                            <span> Phản hồi</span>
                                        </a>
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

    <div id="modal-feedback-prompt" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" action="{{ URL::action('FeedbacksController@check') }}" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Duyệt phản hồi</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>
                                Khi duyệt phản hồi, hệ thống sẽ tự động gửi một email thông báo đến người dùng.<br/>
                                Nếu muốn bạn có thể nhập nội dung đính kèm.
                            </p>
                                <label>To:</label> <span class="user_email"></span>
                                <input name="feedback_id" type="hidden">
                                {{ csrf_field() }}
                                <textarea  style="width: 100%" rows="10" name="message"></textarea>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('input').on('ifToggled', function(event){
                $.ajax({
                    url: location.pathname + '/config',
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
        $('#modal-feedback-prompt').on('show.bs.modal', function(e) {
            feedback_id = $(e.relatedTarget).data('feedback_id');
            user_email = $(e.relatedTarget).data('user_email');
            $(e.currentTarget).find('input[name="feedback_id"]').val(feedback_id);
            $(e.currentTarget).find('span.user_email').text(user_email);
        });
    </script>
@endsection
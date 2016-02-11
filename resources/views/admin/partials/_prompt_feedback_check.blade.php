@section('feedback-check_inputs')
    <label>To:</label> <span class="user_email"></span>
    <input name="feedback_id" type="hidden">
    <textarea  style="width: 100%" rows="10" name="message"></textarea>
@endsection

@include('admin.partials._prompt',[
    'id' => 'feedback-check',
    'method' => 'post',
    'action' => URL::action('FeedbacksController@check'),
    'title' => 'Duyệt phản hồi',
    'message' => 'Khi duyệt phản hồi, hệ thống sẽ tự động gửi một email thông báo đến người dùng.<br/>
                            Nếu muốn bạn có thể nhập nội dung đính kèm.',
])

@section('footer-script')
    @parent
    <script>
        $('#modal-feedback-check-prompt').on('show.bs.modal', function(e) {
            feedback_id = $(e.relatedTarget).data('feedback_id');
            user_email = $(e.relatedTarget).data('user_email');
            $(e.currentTarget).find('input[name="feedback_id"]').val(feedback_id);
            $(e.currentTarget).find('span.user_email').text(user_email);
        });
    </script>
@endsection
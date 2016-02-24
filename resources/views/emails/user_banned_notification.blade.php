@extends('emails.templates.simple_email')

@section('simple_email_title')
    <span>Tài khoản của bạn đã bị khóa</span>
@endsection

@section('simple_email_banner')
    <a target="_blank" href="#">
        <img
                class="bigimage"
                width="540"
                border="0"
                height="282"
                alt=""
                style="display:block; border:none; outline:none; text-decoration:none;"
                src="http://previews.123rf.com/images/corund/corund1309/corund130900603/22214262-Welcome-Banner-clipping-path-included--Stock-Photo-sign.jpg">
    </a>
@endsection

@section('simple_email_content')
    <p>Chào {{ $first_name }} {{ $last_name }},</p>

    <p>
        Quản trị viên {{ $staff_first_name }} {{ $staff_last_name }} đã khóa tài khoản {{ $name }} của bạn tại NEWS.<br/>
    </p>

    @if(!empty($reason))
    <h5>Lý do</h5>
    <p>
        {{ $reason }}
    </p>
    @endif

    @if($expired_at != null)
        <h5>Thời hạn</h5>
        <p>Tài khoản của bạn sẽ được tự động gỡ khóa sau: {{ $expired_at }}</p>
    @else
        <p>Thời hạn khóa không xác định.</p>
    @endif

    @if(!empty($staff_message))
        <h5>Thông điệp của quản trị viên {{ $staff_first_name }} {{ $staff_last_name }}:</h5>
        <p>
            {{ $staff_message }}
        </p>
    @endif

    <br/>
    <p>
        Vui lòng không trả lời (reply) thư này, hệ thống không theo dõi hộp thư này.
        Nếu bạn cần hỗ trợ vui lòng liên hệ chúng tôi hoặc truy cập FAQ tại NEWS.
    </p>

    <br/>
    <p>
        Cảm ơn,
        NEWS
    </p>
@endsection
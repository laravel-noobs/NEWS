@extends('emails.templates.simple_email')

@section('simple_email_title')
    <span>Xác thực email đăng ký</span>
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
        Bạn đã đăng ký tài khoản có tên "{{ $name }}" sử dụng email này và  tài khoản đó chưa được chứng thực.<br/>
        Vui lòng xác thực địa chỉ email bằng cách click chuột vào đường dẫn sau:<br/>
        <a href="{{ url(action('UsersController@getVerifyEmailByLink', ['verify_token' => $verify_token])) }}">{{ url(action('UsersController@getVerifyEmailByLink', ['verify_token' => $verify_token])) }}</a>
    </p>
    {{--
    <p>
        Nếu bạn không thực hiện việc đăng ký này, vui lòng click vào đường dẫn sau để thực hiện xóa tài khoản:<br/>
        <a href="#">Xóa tài khoản "{{ $name }}"</a>
    </p>
    --}}
    <p>
        Nếu bạn cần hỗ trợ vui lòng liên hệ chúng tôi hoặc truy cập FAQ tại NEWS.
    </p>

    <p>
        Cảm ơn bạn,
        NEWS
    </p>
@endsection
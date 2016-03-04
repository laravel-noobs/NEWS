@extends('emails.templates.simple_email')

@section('simple_email_title')
    <span>Cảm ơn phản hồi</span>
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

        @if(get_class($feedback->feedbackable) == \App\Post::class)
            Bạn gửi một phản hồi về bài viết <a href="{{ URL::action('PostsController@show', ['id' => $feedback->feedbackable->id]) }}">{{ $feedback->feedbackable->title }}</a>.<br/>
        @elseif(get_class($feedback->feedbackable) == \App\Product::class)
            Bạn gửi một phản hồi về bài viết <a href="{{ URL::action('ProductsController@show', ['slug' => $feedback->feedbackable->slug]) }}">{{ $feedback->feedbackable->name }}</a>.<br/>
        @endif
        Quản trị viên {{ $staff->first_name }} {{ $staff->last_name }} đã tiếp nhận và đọc phản hồi của bạn.<br/>
    </p>

    <h5>Nội dung phản hồi của bạn</h5>
    <p>
        {{ $feedback->content }}
    </p>

    @if(!empty($staff_message))
    <h5>Trả lời của quản trị viên {{ $staff->first_name }} {{ $staff->last_name }}:</h5>
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
        Cảm ơn bạn đã hỗ trợ,
        NEWS
    </p>
@endsection
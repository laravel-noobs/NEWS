<?php
app('navigator')
        ->activate('comments')
        ->set_page_heading('Sửa bình luận #'. $comment->id)
        ->set_breadcrumb('admin', 'comments', ['comment_edit' => ['text' => 'Sửa']])
        ->set_page_title('Sửa bình luận');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <form method="POST" action="{{ URL::action('CommentsController@update', ['id' => $comment->id]) }}">
            {{ csrf_field() }}
            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Sửa bình luận <small>#{{ $comment->id }}</small></h5>
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
                        <div class="form-horizontal">
                            <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                                <label class="col-sm-2 control-label">Tên</label>
                                <div class="col-sm-10">
                                    <input {{ $comment->user ? 'disabled="disabled"' : '' }} placeholder="Nhập tên khách" id="name" name="name" value="{{ old('name', $comment->name) }}" type="text" class="form-control">
                                    @foreach($errors->get('name') as $err)
                                        <label class="error" for="name">{{ $err }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group {{ count($errors->get('email')) > 0 ? 'has-error' : '' }}">
                                <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input {{ $comment->user ? 'disabled="disabled"' : '' }} placeholder="Nhập địa chỉ email của khách" id="email" name="email" value="{{ old('email', $comment->email) }}" type="text" class="form-control">
                                    @foreach($errors->get('email') as $err)
                                        <label class="error" for="email">{{ $err }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group {{ count($errors->get('user_id')) > 0 ? 'has-error' : '' }}">
                                <label class="col-sm-2 control-label">Thành viên</label>
                                <div class="col-sm-10">
                                    <select id="user_id" name="user_id" class="form-control">
                                        @if($comment->user)
                                            <option value="{{ $comment->user->id }}" selected="selected">{{ $comment->user->name }}</option>
                                        @endif
                                    </select>
                                    @foreach($errors->get('user_id') as $err)
                                        <label class="error" for="user_id">{{ $err }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group {{ count($errors->get('post_id')) > 0 ? 'has-error' : '' }}">
                                <label class="col-sm-2 control-label">Bài viết</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <select id="post_id" name="post_id" class="form-control">
                                            <option  value="{{ $comment->post->id }}" selected="selected">{{ $comment->post->title }}</option>
                                        </select>
                                        <div class="input-group-btn">
                                            <a href="{{ URL::action('PostsController@show', ['id' => $comment->post->id]) }}" id="post_show" style="height: 28px" type="button" class="btn btn-default btn-sm">Xem</a>
                                        </div>
                                    </div>
                                    @foreach($errors->get('post_id') as $err)
                                        <label class="error" for="post_id">{{ $err }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nội dung</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="content" id="content" rows="10" cols="80">{{ old('content', $comment->content) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Trạng thái</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group date">
                                        <input id="created_at" type="hidden" name="created_at" />
                                        <input id="datetimepicker_created_at" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <select style="height:36px" id="status_id" name="status_id" class="form-control">
                                            @foreach($comment_status as $status)
                                                @if(old('status_id', $comment->status_id) == $status['id'])
                                                    <option selected="selected" value="{{ $status->id }}">{{ $status->name }}</option>
                                                @else
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="i-checks input-group-addon">
                                            <label style="margin-bottom: 0">
                                                <input  value="1" type="checkbox" name="spam" {{  $comment->spam ? 'checked' : '' }}/> Spam
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <a class="btn btn-default" href="{{ URL::previous() }}" value="save">Quay lại</a>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary pull-right" type="submit" value="save">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer-script')
    <script src="{{URL::asset('js/editor/ckeditor.js')}}"></script>
    <script>
        $('#datetimepicker_created_at').datetimepicker({
            format: 'MMMM Do YYYY, HH:mm:ss',
            defaultDate: moment.tz('{{ old('created_at', $comment->created_at) }}', 'UTC').tz(moment.tz.guess()).format()
        });

        $('button[type="submit"]').click(function(e)
        {
            // get datetime from datetimepicker plugin
            time = $('#datetimepicker_created_at').data("DateTimePicker").date();
            // corecting timezone (wrong because of datetimepicker bug)
            time = moment.tz(time.format('YYYY-MM-DD HH:mm:ss'), moment.tz.guess()).format();
            // converting timezone to UTC and send back to server
            $('#created_at').val(moment(time).utc().format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $("#post_id").select2({
            placeholder: "Chọn một bài viết",
            ajax: {
                url: '{{ URL::action('PostsController@queryPostsByTitle') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function (data, params) {
                    $.map(data, function (data) {
                        data.id = data.id;
                        data.text = data.title;
                        data.url = data.url
                    });
                    return {
                        results: data
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 3,
            templateResult: function (item) {
                if (item.loading) return item.text;
                markup = '<div><span>' + item.text + '</span></div>';
                return markup;
            },
            templateSelection: function (item) {
                return '<option data-url="' + item.url + '" style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
            }
        });
        $("#post_id").on("select2:select", function (e) {
            $('#post_show').attr('href', e.params.data.url);
        });

        $("#user_id").select2({
            placeholder: "Chọn một người dùng",
            allowClear: true,
            ajax: {
                url: '{{ URL::action('UsersController@queryUsers') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function (data, params) {
                    $.map(data, function (data) {
                        data.id = data.id;
                        data.text = data.name;
                    });
                    return {
                        results: data
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 3,
            templateResult: function (item) {
                if (item.loading) return item.text;
                markup = '<div><span>' + item.text + '</span></div>';
                return markup;
            },
            templateSelection: function (item) {
                return '<option selected="selected" style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
            }
        });
        $("#user_id").on("select2:select", function (e) {
            $('#name, #email').attr('disabled', 'disabled');
        });
        $("#user_id").on("select2:unselect", function (e) {
            $('#name, #email').attr('disabled', false)
        });
    </script>
@endsection
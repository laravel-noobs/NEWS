<?php
app('navigator')
        ->activate('products', 'reviews')
        ->set_page_heading('Sửa đánh giá sản phẩm')
        ->set_breadcrumb('admin', 'product_reviews', 'product_review_edit')
        ->set_page_title('Sửa đánh giá sản phẩm');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Sửa đánh giá sản phẩm</h3>
                    <form method="POST" action="{{ action('ProductReviewsController@update', ['id' => $review->id ]) }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input {{ $review->user ? 'disabled="disabled"' : '' }} type="text" id="name" name="name" placeholder="" value="{{ old('name', $review->name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của khách đánh giá sản phẩm.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group {{ count($errors->get('email')) > 0 ? 'has-error' : '' }}">
                            <label class="">Email</label>
                            <input {{ $review->user ? 'disabled="disabled"' : '' }} type="text" id="email" name="email" placeholder="" value="{{ old('email', $review->email) }}" class="form-control">
                            <span class="help-block m-b-none">Email của khách đánh giá sản phẩm.</span>
                            @foreach($errors->get('email') as $err)
                                <label class="error" for="email">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group {{ count($errors->get('user_id')) > 0 ? 'has-error' : '' }}">
                            <label class="">Thành viên</label>
                            <select id="user_id" name="user_id" class="form-control">
                                @if($review->user)
                                    <option value="{{ $review->user->id }}" selected="selected">{{ $review->user->name }}</option>
                                @endif
                            </select>
                            @foreach($errors->get('user_id') as $err)
                                <label class="error" for="user_id">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group {{ count($errors->get('content')) > 0 ? 'has-error' : '' }}">
                            <label>Nội dung</label>
                            <textarea id="content" name="content" placeholder="" class="form-control" rows="10" cols="50">{{ old('content', $review ->content) }}</textarea>
                            <span class="help-block m-b-none">Nội dung đánh giá sản phẩm.</span>
                            @foreach($errors->get('content') as $err)
                                <label class="error" for="content">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group {{ count($errors->get('product_id')) > 0 ? 'has-error' : '' }}">
                            <label>Bài viết</label>
                            <div class="input-group">
                                <select id="product_id" name="product_id" class="form-control">
                                    <option  value="{{ $review->product->id }}" selected="selected">{{ $review->product->name }}</option>
                                </select>
                                <div class="input-group-btn">
                                    <a href="{{ URL::action('ProductsController@show', ['id' => $review->product->id]) }}" id="product_show" style="height: 28px" type="button" class="btn btn-default btn-sm">Xem</a>
                                </div>
                            </div>
                            @foreach($errors->get('product_id') as $err)
                                <label class="error" for="product_id">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <label>Ngày tạo</label>
                            <div class="input-group date">
                                <input id="created_at" type="hidden" name="created_at" />
                                <input id="datetimepicker_created_at" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div>
                                <button class="btn btn-primary" type="submit" value="Sửa">Sửa</button>
                                <a href="{{ URL::action('ProductReviewsController@index') }}" class="btn btn-white"> Quay lại danh sách</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        $('#datetimepicker_created_at').datetimepicker({
            format: 'MMMM Do YYYY, HH:mm:ss',
            defaultDate: moment.tz('{{ old('created_at', $review->created_at) }}', 'UTC').tz(moment.tz.guess()).format()
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

        $("#product_id").select2({
            placeholder: "Chọn một sản phẩm",
            ajax: {
                url: '{{ URL::action('ProductsController@queryProducts') }}',
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
        $("#product_id").on("select2:select", function (e) {
            $('#product_show').attr('href', e.params.data.url);
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
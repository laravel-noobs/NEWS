<?php
app('navigator')
        ->activate('collections', 'create')
        ->set_page_heading('Thêm nhóm sản phẩm')
        ->set_breadcrumb('admin', 'collections', 'collection_create')
        ->set_page_title('Sửa thông tin nhóm sản phẩm ');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <form method="POST" action="{{ action('CollectionsController@store') }}">
            <div class="col-sm-9">
                <div class="ibox ">
                    <div class="ibox-content">

                            {{ csrf_field() }}

                            <div class="form-group {{ count($errors->get('label')) > 0 ? 'has-error' : '' }}">
                                <label class="">Tên hiển thị</label>
                                <input type="text" id="label" name="label" placeholder="" value="{{ old('label', '') }}" class="form-control">
                                <span class="help-block m-b-none">Tên của nhóm sản phẩm được tạo sẽ dùng để hiển thị.</span>
                                @foreach($errors->get('label') as $err)
                                    <label class="error" for="label">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group {{ count($errors->get('image')) > 0 ? 'has-error' : '' }}">
                                <label>Hình</label>
                                <input type="text" id="image" name="image" placeholder="" value="{{ old('image', '') }}" class="form-control">
                                <span class="help-block m-b-none">Hình đại diện.</span>
                                @foreach($errors->get('image') as $err)
                                    <label class="error" for="image">{{ $err }}</label>
                                @endforeach
                            </div>



                            <div class="form-group {{ count($errors->get('slug')) > 0 ? 'has-error' : '' }}">
                                <label>Slug</label>
                                <input type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', '') }}" class="form-control">
                                <span class="help-block m-b-none">Chuỗi ký tự dùng để tạo đường dẫn thân thiện, chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.</span>
                                @foreach($errors->get('slug') as $err)
                                    <label class="error" for="slug">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                                <label>Mô tả</label>
                                <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', '') }}</textarea>
                                <span class="help-block m-b-none">Mô tả nhóm sản phẩm tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
                                @foreach($errors->get('description') as $err)
                                    <label class="error" for="description">{{ $err }}</label>
                                @endforeach
                            </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhóm sản phẩm, dùng để quản lý, chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label>Hiển thị</label>
                            <div class="input-group date">
                                <input id="expired_at" type="hidden" name="expired_at" />
                                <div class="i-checks input-group-addon">
                                    <label style="margin-bottom: 0">
                                        <input value="1" type="checkbox" name="enabled" {{  old('spam', true) ? 'checked' : '' }}/>
                                    </label>
                                </div>
                                <input id="datetimepicker_expired_at" style="height:36px" type='text' class="form-control" />
                            </div>
                            @foreach($errors->get('expired_at') as $err)
                                <label class="error" for="expired_at">{{ $err }}</label>
                            @endforeach
                        </div>


                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div>
                                <a href="{{ URL::action('CollectionsController@index') }}" class="btn btn-white"> Quay lại</a>
                                <button class="btn btn-primary pull-right" type="submit">Lưu thay đổi</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
        $('#datetimepicker_expired_at').datetimepicker({
            format: 'Do MMMM YYYY HH:mm:ss'
        });
        $('button[type="submit"]').click(function(e) {
            // get datetime from datetimepicker plugin
            time = $('#datetimepicker_expired_at').data("DateTimePicker").date();
            // corecting timezone (wrong because of datetimepicker bug)
            if(time != null)
            {
                time = moment.tz(time.format('YYYY-MM-DD HH:mm:ss'), moment.tz.guess()).format();
                // converting timezone to UTC and send back to server
                $('#expired_at').val(moment(time).utc().format('YYYY-MM-DD HH:mm:ss'));
                return;
            }
            $('#expired_at').val('');
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
    </script>
@endsection
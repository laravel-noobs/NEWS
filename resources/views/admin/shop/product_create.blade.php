<?php
app('navigator')
        ->activate('products', 'create')
        ->set_page_heading('Thêm sản phẩm')
        ->set_breadcrumb('admin', 'products', 'product_create')
        ->set_page_title('Thêm sản phẩm ');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <form method="POST" action="{{ action('ProductsController@store') }}">
            <div class="col-sm-9">
                <div class="ibox ">
                    <div class="ibox-content">

                        {{ csrf_field() }}

                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của sản phẩm được tạo sẽ dùng để hiển thị.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
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

                        <div class="form-group {{ count($errors->get('image')) > 0 ? 'has-error' : '' }}">
                            <label>Hình</label>
                            <input type="text" id="image" name="image" placeholder="" value="{{ old('image', '') }}" class="form-control">
                            <span class="help-block m-b-none">Hình đại diện.</span>
                            @foreach($errors->get('image') as $err)
                                <label class="error" for="image">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('featured_image')) > 0 ? 'has-error' : '' }}">
                            <label>Hình nổi bật</label>
                            <input type="text" id="featured_image" name="featured_image" placeholder="" value="{{ old('featured_image', '') }}" class="form-control">
                            <span class="help-block m-b-none">Hình có thể được hiển thị trên silde ngang.</span>
                            @foreach($errors->get('featured_image') as $err)
                                <label class="error" for="featured_image">{{ $err }}</label>
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

                        <div class="form-group {{ count($errors->get('package')) > 0 ? 'has-error' : '' }}">
                            <label>Hình thức</label>
                            <input type="text" id="package" name="package" placeholder="" value="{{ old('package', '') }}" class="form-control">
                            <span class="help-block m-b-none">Hình thức của sản phẩm, cách đóng gói.</span>
                            @foreach($errors->get('package') as $err)
                                <label class="error" for="package">{{ $err }}</label>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox ">
                    <div class="ibox-content">

                        <div class="form-group {{ count($errors->get('price')) > 0 ? 'has-error' : '' }}">
                            <label class="">Giá</label>
                            <input type="text" id="price" name="price" placeholder="" value="{{ old('price', '') }}" class="form-control">
                            @foreach($errors->get('price') as $err)
                                <label class="error" for="price">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('status_id')) > 0 ? 'has-error' : '' }}">
                            <label class="">Trạng thái</label>
                            <select id="status_id" name="status_id" class="form-control">
                                @foreach($product_status as $status)
                                    @if(old('status_id') == $status->id || ($status->id == $post_status_default_id && old('status_id') == null))
                                        <option selected="selected" value="{{ $status->id }}">{{ $status->label }}</option>
                                    @else
                                        <option value="{{ $status->id }}">{{ $status->label }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @foreach($errors->get('status_id') as $err)
                                <label class="error" for="status_id">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('category_id')) > 0 ? 'has-error' : '' }}">
                            <label class="">Danh mục</label>
                            <select id="category_id" name="category_id" class="category form-control">
                                @foreach($categories as $category)
                                    @if(old('category_id') == $category->id && old('category_id') == null))
                                        <option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @foreach($errors->get('category_id') as $err)
                                <label class="error" for="category_id">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('brand_id')) > 0 ? 'has-error' : '' }}">
                            <label class="">Nhãn hiệu</label>
                            <select id="brand_id" name="brand_id" class="brand form-control">
                                @foreach($brands as $brand)
                                    @if(old('brand_id') == $brand->id && old('brand_id') == null))
                                    <option selected="selected" value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @else
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @foreach($errors->get('brand_id') as $err)
                                <label class="error" for="brand_id">{{ $err }}</label>
                            @endforeach
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div>
                                <a href="{{ URL::action('ProductsController@index') }}" class="btn btn-white"> Quay lại</a>
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
        $(".category").select2({
            placeholder: "Chọn một danh mục",
        });
        $(".brand").select2({
            placeholder: "Chọn một nhãn hiệu",
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
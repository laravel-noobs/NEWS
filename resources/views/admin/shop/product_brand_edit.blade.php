<?php
app('navigator')
        ->activate('products', 'brands')
        ->set_page_heading('Sửa thông tin nhãn hiệu sản phẩm')
        ->set_breadcrumb('admin', 'product_brands', 'product_brand_edit')
        ->set_page_title('Sửa thông tin nhãn hiệu ' . $brand->name);
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Sửa nhãn hiệu</h3>
                    <form method="POST" action="{{ action('ProductBrandsController@update', ['id' => $brand->id ]) }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', $brand->name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhãn hiệu được tạo sẽ dùng để hiển thị.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('label')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên hiển thị</label>
                            <input type="text" id="label" name="label" placeholder="" value="{{ old('label', $brand->label) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhãn hiệu được tạo sẽ dùng để hiển thị.</span>
                            @foreach($errors->get('label') as $err)
                                <label class="error" for="label">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('slug')) > 0 ? 'has-error' : '' }}">
                            <label>Slug</label>
                            <input type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', $brand->slug) }}" class="form-control">
                            <span class="help-block m-b-none">Chuỗi ký tự dùng để tạo đường dẫn thân thiện, thường chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.</span>
                            @foreach($errors->get('slug') as $err)
                                <label class="error" for="slug">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', $brand->description) }}</textarea>
                            <span class="help-block m-b-none">Mô tả nhãn hiệu tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
                            @foreach($errors->get('description') as $err)
                                <label class="error" for="description">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div>
                                <input class="btn btn-primary" type="submit" value="Sửa">
                                <a href="{{ URL::previous() }}" class="btn btn-white"> Quay lại</a>
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
        $(document).ready(function(){
            $('.footable').footable();
        });
    </script>
@endsection
<?php
app('navigator')
        ->activate('products')
        ->set_page_heading('Sửa sản phẩm')
        ->set_breadcrumb('admin', 'products', 'product_edit');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <form method="POST" action="{{ URL::action('ProductsController@update', ['id' => $product->id]) }}">
            {{ csrf_field() }}

            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Sửa sản phẩm <strong>{{ $product->name }}</strong></h5>
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
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', $product->name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của sản phẩm dùng để hiển thị.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('slug')) > 0 ? 'has-error' : '' }}">
                            <label>Slug</label>
                            <input type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', $product->slug) }}" class="form-control">
                            <span class="help-block m-b-none">Chuỗi ký tự dùng để tạo đường dẫn thân thiện, chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.</span>
                            @foreach($errors->get('slug') as $err)
                                <label class="error" for="slug">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('image')) > 0 ? 'has-error' : '' }}">
                            <label>Hình</label>
                            <input type="text" id="image" name="image" placeholder="" value="{{ old('image', $product->image) }}" class="form-control">
                            <span class="help-block m-b-none">Hình đại diện.</span>
                            @foreach($errors->get('image') as $err)
                                <label class="error" for="image">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('featured_image')) > 0 ? 'has-error' : '' }}">
                            <label>Hình nổi bật</label>
                            <input type="text" id="featured_image" name="featured_image" placeholder="" value="{{ old('featured_image', $product->featured_image) }}" class="form-control">
                            <span class="help-block m-b-none">Hình có thể được hiển thị trên silde ngang.</span>
                            @foreach($errors->get('featured_image') as $err)
                                <label class="error" for="featured_image">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', $product->description) }}</textarea>
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
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thẻ của sản phẩm</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <select name="tags[]" id="tags" class="tags form-control" multiple="multiple">
                                        @foreach(old('new_tags', []) as $tag)
                                            <option value="{{ $tag['name'] }}" data-select2-tag="true" selected="selected">{{ $tag['name'] }}</option>
                                        @endforeach
                                        @foreach(old('existed_tags', $product->tags) as $tag)
                                            <option value="{{ $tag['id'] }}" selected="selected">{{ $tag['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @foreach($errors->toArray() as $k => $v)
                                        @if(str_contains($k, 'new_tags'))
                                            @foreach($v as $err)
                                                <label class="error" for="tags[]">{{ $err }}</label>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lưu sản phẩm</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="form-group {{ count($errors->get('price')) > 0 ? 'has-error' : '' }}">
                            <label class="">Giá</label>
                            <input type="text" id="price" name="price" placeholder="" value="{{ old('price', $product->price) }}" class="form-control">
                            @foreach($errors->get('price') as $err)
                                <label class="error" for="price">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('status_id')) > 0 ? 'has-error' : '' }}">
                            <label class="">Trạng thái</label>
                            <select id="status_id" name="status_id" class="form-control">
                                @foreach($product_status as $status)
                                    @if(old('status_id') == $status->id || old('status_id') == null)
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
                                @if(empty(old('category_name', null)))
                                    @foreach($categories as $cat)
                                        @if(old('category_id', $product->category_id) == $cat['id'])
                                            <option value="{{ old('category_id', $product->category_id) }}" selected="selected">{{ $cat['name'] }}</option>
                                        @else
                                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="{{ old('category_name') }}" selected="selected" data-select2-tag="true">{{ old('category_name') }}</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @foreach($errors->get('category_id') as $err)
                                <label class="error" for="category_id">{{ $err }}</label>
                            @endforeach
                            @foreach($errors->get('category_name') as $err)
                                <label class="error" for="category_id">{{ $err }}</label>
                            @endforeach
                            @foreach($errors->get('category_slug') as $err)
                                <label class="error" for="category_id">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('brand_id')) > 0 ? 'has-error' : '' }}">
                            <label class="">Nhãn hiệu</label>
                            <select id="brand_id" name="brand_id" class="brand form-control">
                                @if(empty(old('brand_name', null)))
                                    @foreach($brands as $brand)
                                        @if(old('brand_id', $product->brand_id) == $brand['id'])
                                            <option value="{{ old('brand_id', $product->brand_id) }}" selected="selected">{{ $brand['name'] }}</option>
                                        @else
                                            <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                        @endif
                                    @endforeach
                                @else
                                    <option value="{{ old('brand_name') }}" selected="selected" data-select2-tag="true">{{ old('brand_name') }}</option>
                                    @foreach($brandegories as $brand)
                                        <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @foreach($errors->get('brand_id') as $err)
                                <label class="error" for="brand_id">{{ $err }}</label>
                            @endforeach
                            @foreach($errors->get('brand_name') as $err)
                                <label class="error" for="brand_id">{{ $err }}</label>
                            @endforeach
                            @foreach($errors->get('brand_slug') as $err)
                                <label class="error" for="brand_id">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                                <a class="btn btn-default" href="{{ URL::action('ProductsController@index') }}">Danh sách</a>
                                <button class="btn btn-primary pull-right" type="submit" value="save">Lưu</button>
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
        $(".category").select2({
            placeholder: "Chọn một chuyên mục"
        }).trigger("change");

        $(".brand").select2({
            placeholder: "Chọn một nhãn hiệu"
        }).trigger("change");

        $('button[type="submit"]').click(function(e)
        {
            $('#tags option[data-select2-tag="true"]').each(function(){
                $(this).val('*-' + $(this).text());
            }); // manually set value to non existed tags
        });

        $("#tags").select2({
            @can('updatePostWithNewTag')
            tags: true,
            @endcan
            ajax: {
                url: '{{ URL::action('TagsController@queryTags') }}',
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
                if(item.element.dataset.select2Tag == "true")
                    return '<option style="display: inline" value="0" selected="selected">' + item.text + '</option>'; // seem not to work, before submit hack
                else
                    return '<option style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
            }
        });
    </script>

@endsection
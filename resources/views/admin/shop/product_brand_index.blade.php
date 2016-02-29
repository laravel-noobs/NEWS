<?php
app('navigator')
        ->activate('products', 'brands')
        ->set_page_heading('Danh sách nhãn hiệu sản phẩm')
        ->set_breadcrumb('admin', 'product_brands')
        ->set_page_title('Danh sách tất cả nhãn hiệu sản phẩm');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        @can('storeProductBrand')
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới nhãn hiệu</h3>
                    <form method="POST" action="{{ URL::action('ProductBrandsController@store') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhãn hiệu.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('label')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên hiển thị</label>
                            <input type="text" id="label" name="label" placeholder="" value="{{ old('label', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhãn hiệu được tạo sẽ dùng để hiển thị.</span>
                            @foreach($errors->get('label') as $err)
                                <label class="error" for="label">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('slug')) > 0 ? 'has-error' : '' }}">
                            <label>Slug</label>
                            <input type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', '') }}" class="form-control">
                            <span class="help-block m-b-none">Chuỗi ký tự dùng để tạo đường dẫn thân thiện, thường chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.</span>
                            @foreach($errors->get('slug') as $err)
                                <label class="error" for="slug">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', '') }}</textarea>
                            <span class="help-block m-b-none">Mô tả nhãn hiệu tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
                            @foreach($errors->get('description') as $err)
                                <label class="error" for="description">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div>
                                <input class="btn btn-primary" type="submit" value="Thêm mới">
                                <a href="{{ URL::previous() }}" class="btn btn-white"> Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
        @else
        <div class="col-sm-12">
        @endcan
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">{{ count($brands) }} nhãn hiệu</span>
                    <h2>Danh sách</h2>
                    <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Tìm kiếm">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15" data-filter="#filter">
                        <thead>
                        <tr>
                            <th>Tên hiển thị</th>
                            <th data-hide="all">Tên</th>
                            <th data-hide="all">Slug</th>
                            <th>Mô tả</th>
                            <th data-hide="phone"><span class="pull-right">Sản phẩm</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{ $brand->label }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->slug }}</td>
                                <td>
                                    {{ $brand->description }}
                                    <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                        @can('updateProductBrand')
                                        <li class="">
                                            <a class="text-success" href="{{ action('ProductBrandsController@edit', ['id' => $brand->id]) }}">Sửa</a>
                                        </li>
                                        @endcan
                                        @can('destroyProductBrand')
                                        <li class="">
                                            <a data-toggle="modal" class="text-danger" href="#modal-brand-delete-prompt" data-brand_label="{{ $brand->label }}" data-brand_id="{{ $brand->id }}">Xóa</a>
                                        </li>
                                        @endcan
                                    </ul>
                                </td>
                                <td><span class="pull-right">{{ $brand->productsCount }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('destroyProductBrand')
        @section('brand-delete_inputs')
            <input name="brand_id" type="hidden"/>
        @endsection
        @include('admin.partials._prompt',[
            'id' => 'brand-delete',
            'method' => 'post',
            'action' => URL::action('ProductBrandsController@destroy'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn xóa nhãn hiệu "<span class="brand_label">này</span>" hay không?',
        ])
    @endcan
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
        $('#modal-brand-delete-prompt').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('input[name="brand_id"]').val($(e.relatedTarget).data('brand_id'));
            $(e.currentTarget).find('span.brand_label').text($(e.relatedTarget).data('brand_label'));
        });
    </script>
@endsection
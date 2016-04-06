<?php
app('navigator')
        ->activate('products', 'categories')
        ->set_page_heading('Danh sách danh mục sản phẩm')
        ->set_breadcrumb('admin', 'product_categories')
        ->set_page_title('Danh sách tất cả danh mục sản phẩm');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        @can('storeProductCategory')
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới danh mục</h3>
                    <form method="POST" action="{{ URL::action('ProductCategoriesController@store') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của danh mục được tạo sẽ dùng để hiển thị.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
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

                        <div class="form-group {{ count($errors->get('parent_id')) > 0 ? 'has-error' : '' }}">
                            <label>Danh mục cha</label>
                            <select type="text" id="parent_id" name="parent_id" placeholder="" class="form-control">
                                <option value="">Không có</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block m-b-none">Danh mục mới có thể là danh mục con một danh mục khác. Chọn danh mục cha cho danh mục con sẽ được tạo.</span>
                            @foreach($errors->get('parent_id') as $err)
                                <label class="error" for="{{ 'parent_id' }}">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', '') }}</textarea>
                            <span class="help-block m-b-none">Mô tả danh mục tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
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
                    <span class="text-muted small pull-right">{{ count($categories) }} danh mục</span>
                    <h2>Danh sách</h2>
                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="Tìm kiếm">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15" data-filter="#filter">
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th data-hide="all">Slug</th>
                            <th>Mô tả</th>
                            <th data-hide="phone"><span class="pull-right"> Sản phẩm</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->name }}</td>
                                <td>{{ $cat->slug }}</td>
                                <td>
                                    {{ $cat->description }}
                                    <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                        @can('updateProductCategory')
                                        <li class="">
                                            <a href="{{ URL::action('ProductCategoriesController@edit', ['id' => $cat->id]) }}" class="text-success">Sửa</a>
                                        </li>
                                        @endcan
                                        @can('destroyProductCategory')
                                        <li class="">
                                            <a data-toggle="modal" class="text-danger" href="#modal-category-delete-prompt" data-cat_name="{{ $cat->name }}" data-cat_id="{{ $cat->id }}">Xóa</a>
                                        </li>
                                        @endcan
                                    </ul>
                                </td>
                                <td><span class="pull-right">{{ $cat->productsCount }}</span></td>
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

        @can('destroyProductCategory')
        @section('category-delete_inputs')
            <input name="cat_id" type="hidden"/>
        @endsection
        @include('admin.partials._prompt',[
            'id' => 'category-delete',
            'method' => 'post',
            'action' => URL::action('ProductCategoriesController@destroy'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn xóa danh mục "<span class="cat_name">này</span>" hay không?',
        ])
        @endcan
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
        $('#modal-category-delete-prompt').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('input[name="cat_id"]').val($(e.relatedTarget).data('cat_id'));
            $(e.currentTarget).find('span.cat_name').text($(e.relatedTarget).data('cat_name'));
        });
    </script>
@endsection
<?php
    app('navigator')
            ->activate('posts', 'categories')
            ->set_page_heading('Danh sách chuyên mục')
            ->set_breadcrumb('admin', 'categories')
            ->set_page_title('Danh sách tất cả chuyên mục');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới chuyên mục</h3>
                    <form method="POST" action="{{ URL::action('CategoriesController@store') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của chuyên mục được tạo sẽ dùng để hiển thị.</span>
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
                            <label>Chuyên mục mẹ</label>
                            <select type="text" id="parent_id" name="parent_id" placeholder="" class="form-control">
                                <option value="">Không có</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block m-b-none">Chuyên mục mới có thể là chuyên mục con một chuyên mục khác. Chọn chuyên mục mẹ cho chuyên mục con sẽ được tạo.</span>
                            @foreach($errors->get('parent_id') as $err)
                                <label class="error" for="{{ 'parent_id' }}">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', '') }}</textarea>
                            <span class="help-block m-b-none">Mô tả chuyên mục tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
                            @foreach($errors->get('description') as $err)
                                <label class="error" for="description">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div>
                                <input class="btn btn-primary" type="submit" value="Thêm mới">
                                <a href="#" class="btn btn-white"> Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">{{ count($categories) }} chuyên mục</span>
                    <h2>Danh sách</h2>
                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="Tìm kiếm">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th data-hide="all">Slug</th>
                            <th data-hide="phone, tablet">Mô tả</th>
                            <th data-hide="phone">Bài viết</th>
                            <th data-sort-ignore="true"><span class="pull-right">Hành động</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $cat)
                            <tr>
                                <td>{{ $cat->name }}</td>
                                <td>{{ $cat->slug }}</td>
                                <td>{{ $cat->description }}</td>
                                <td>{{ $cat->postsCount }}</td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <a href="{{ action('CategoriesController@edit', ['id' => $cat->id]) }}"  class="btn-white btn btn-xs">Sửa</a>
                                        <a href="#" target="_blank" class="btn-white btn btn-xs">Xem</a>
                                        <a href="{{ action('CategoriesController@destroy', ['id' => $cat->id]) }}" class="btn-white btn btn-xs">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <ul class="pagination pull-right"></ul>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
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
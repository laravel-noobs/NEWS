<?php
app('navigator')
        ->activate('posts', 'tags')
        ->set_page_heading('Danh sách tag')
        ->set_breadcrumb('admin', 'tags')
        ->set_page_title('Danh sách tất cả tag');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới tag</h3>
                    <form method="POST" action="{{ URL::action('TagsController@store') }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', '') }}" class="form-control">
                            <span class="help-block m-b-none">Tên của tag được tạo sẽ dùng để hiển thị.</span>
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

                        {{--
                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', '') }}</textarea>
                            <span class="help-block m-b-none">Mô tả tag tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
                            @foreach($errors->get('description') as $err)
                                <label class="error" for="description">{{ $err }}</label>
                            @endforeach
                        </div>
                        --}}
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
                    <span class="text-muted small pull-right">{{ count([]) }} chuyên mục</span>
                    <h2>Danh sách</h2>
                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="Tìm kiếm">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Bài viết</th>
                            <th data-sort-ignore="true"><span class="pull-right">Hành động</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->slug }}</td>
                                <td>{{ $tag->postsCount }}</td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <a href="{{ action('TagsController@edit', ['id' => $tag->id]) }}"  class="btn-white btn btn-xs">Sửa</a>
                                        <a href="#" target="_blank" class="btn-white btn btn-xs">Xem</a>
                                        <a href="{{ action('TagsController@destroy', ['id' => $tag->id]) }}" class="btn-white btn btn-xs">Xóa</a>
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
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
                                <a href="{{ URL::action('TagsController@index') }}" class="btn btn-white"> Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">Tổng cộng {{ $tags->total() }} tags</span>
                    <h2>Danh sách</h2>
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="20" data-filter=#filter>
                        <thead>
                        <tr>
                            <th data-sort-ignore="true">Tên</th>
                            <th data-sort-ignore="true">Slug</th>
                            <th data-sort-ignore="true">Bài viết</th>
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
                                        {{-- <a href="{{ action('TagsController@destroy', ['id' => $tag->id]) }}" class="btn-white btn btn-xs">Xóa</a> --}}
                                        <a data-toggle="modal" href="#modal-tag-delete-prompt" data-tag_name="{{ $tag->name }}" data-tag_id="{{ $tag->id }}" class="btn-white btn btn-xs">Xóa</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pull-right">{!! $tags->links() !!}</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @section('tag-delete_inputs')
        <input name="tag_id" type="hidden"/>
    @endsection
    @include('admin.partials._prompt',[
        'id' => 'tag-delete',
        'method' => 'post',
        'action' => URL::action('TagsController@destroy'),
        'title' => 'Xác nhận',
        'message' => 'Bạn có chắc chắn muốn xóa thẻ "<span class="tag_name">này</span>" hay không?',
    ])

@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
        //triggered when modal is about to be shown
        $('#modal-tag-delete-prompt').on('show.bs.modal', function(e) {
            tag_id = $(e.relatedTarget).data('tag_id');
            tag_name = $(e.relatedTarget).data('tag_name');
            $(e.currentTarget).find('input[name="tag_id"]').val(tag_id);
            $(e.currentTarget).find('span.tag_name').text(tag_name);
        });
    </script>
@endsection
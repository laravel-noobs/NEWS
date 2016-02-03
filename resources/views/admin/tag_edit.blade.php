<?php
app('navigator')
        ->activate('posts', 'tags')
        ->set_page_heading('Sửa thông tin tag')
        ->set_breadcrumb('admin', 'tags', 'tag_edit')
        ->set_page_title('Sửa thông tin tag' . $tag->name);
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới tag</h3>
                    <form method="POST" action="{{ URL::action('TagsController@update', ['id' => $tag->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', $tag->name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của tag được tạo sẽ dùng để hiển thị.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('slug')) > 0 ? 'has-error' : '' }}">
                            <label>Slug</label>
                            <input type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', $tag->slug) }}" class="form-control">
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
                                <input class="btn btn-primary" type="submit" value="Lưu thay đổi">
                                <a data-toggle="modal" href="#modal-delete-prompt" data-tag_name="{{ $tag->name }}" data-tag_id="{{ $tag->id }}" class="btn btn-danger">Xóa</a>
                                <a href="{{ URL::action('TagsController@index') }}" class="btn btn-white">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">Tổng cộng {{$tag->postsCount }} bài viết</span>
                    <h2>Danh sách bài viết có tag này</h2>
                    @if($tag->postsCount > 0)
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8">
                        <thead>
                        <tr>
                            <th data-toggle="true">Tiêu đề</th>
                            <th data-hide="all">Tác giả</th>
                            <th>Chuyên mục</th>
                            <th data-hide="all">Ngày đăng</th>
                            <th>Tình trạng</th>
                            <th>Lượt xem</th>
                            <th data-sort-ignore="true">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tag->posts as $post)
                            <tr>
                                <td><a href="{{ URL::action('PostsController@show', ['id'=>$post->id]) }}">{{ $post->title }}</a></td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->category != null ? $post->category->name : '' }}</td>
                                <td>{{ $post->published_at }}</td>
                                <td>{{ $post->postStatus->name }}</td>
                                <td>{{ $post->view }}</td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <a href="{{ URL::action('PostsController@edit', ['id'=>$post->id]) }}"  class="btn-white btn btn-xs">Sửa</a>
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
                    @else
                        <span>Rất tiếc, không có bài viết nào.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="modal-delete-prompt" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12"><h3 class="m-t-none m-b">Xác nhận</h3>
                            <p>Bạn có chắc chắn muốn xóa thẻ "<span class="tag_name">này</span>" hay không?<br/></p>
                            <form role="form" action="{{ URL::action('TagsController@destroy') }}" method="POST">
                                <input name="tag_id" type="hidden">
                                {{ csrf_field() }}
                                <hr/>
                                <div>
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Yes</strong></button>
                                        <button class="btn btn-sm btn-default m-t-n-xs" type="button" data-dismiss="modal"><strong>Close</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
        //triggered when modal is about to be shown
        $('#modal-delete-prompt').on('show.bs.modal', function(e) {
            tag_id = $(e.relatedTarget).data('tag_id');
            tag_name = $(e.relatedTarget).data('tag_name');
            $(e.currentTarget).find('input[name="tag_id"]').val(tag_id);
            $(e.currentTarget).find('span.tag_name').text(tag_name);
        });
    </script>
@endsection
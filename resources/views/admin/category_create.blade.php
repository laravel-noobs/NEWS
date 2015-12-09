@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-5">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới chuyên mục</h3>
                    <form method="POST" action="{{ URL::action('CategoriesController@store') }}">
                        {{ csrf_field() }}
                        @include('partials.admin.controls._textbox', [
                            'caption' => 'Tên',
                            'name' => 'name',
                            'help' => 'Tên của chuyên mục được tạo sẽ dùng để hiển thị.'
                        ])

                        @include('partials.admin.controls._textbox', [
                            'caption' => 'Slug',
                            'name' => 'slug',
                            'help' => 'Chuỗi ký tự dùng để tạo đường dẫn thân thiện, thường chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.'
                        ])

                        <div class="form-group {{ count($errors->get('parent_id')) > 0 ? 'has-error' : '' }}">
                            <label>Phụ mẫu</label>
                            <select type="text" id="parent_id" name="parent_id" placeholder="" class="form-control">
                                <option value="">Không có</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <span class="help-block m-b-none">Chuyên mục mới có thể là chuyên mục con một chuyên mục khác. Chọn chuyên mục phụ mẫu cho chuyên mục con sẽ được tạo.</span>
                            @foreach($errors->get('parent_id') as $err)
                                <label class="error" for="{{ 'parent_id' }}">{{ $err }}</label>
                            @endforeach
                        </div>

                        @include('partials.admin.controls._textarea', [
                            'caption' => 'Mô tả',
                            'name' => 'description',
                            'help' => 'Chuyên mục mới có thể là chuyên mục con một chuyên mục khác. Chọn chuyên mục phụ mẫu cho chuyên mục con sẽ được tạo.',
                            'attr' => 'style="min-height:150px"'
                        ])
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
        <div class="col-sm-7">
            <div class="ibox">
                <div class="ibox-content">
                    <span class="text-muted small pull-right">{{ count($categories) }} chuyên mục</span>
                    <h2>Danh sách</h2>
                    <input type="text" class="form-control input-sm m-b-xs" id="filter"
                           placeholder="Tìm kiếm">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter>
                        <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th data-hide="phone">Mô tả</th>
                            <th>Bài viết</th>
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
                                        <a href="#" target="_blank" class="btn-white btn btn-xs">Sửa</a>
                                        <a href="#" target="_blank" class="btn-white btn btn-xs">Xem</a>
                                        <a href="#" target="_blank" class="btn-white btn btn-xs">Xóa</a>
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
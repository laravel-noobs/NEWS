<?php
app('navigator')
        ->activate('posts', 'create')
        ->set_page_heading('Tạo bài viết mới')
        ->set_breadcrumb('admin', 'posts', 'post_create');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <form method="POST" action="{{ URL::action('PostsController@store') }}">
            {{ csrf_field() }}
            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chức năng thêm bài viết mới <small>thêm bài viết mới trong hệ thống</small></h5>
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
                        <div class="form-horizontal">
                            <div class="form-group {{ count($errors->get('title')) > 0 ? 'has-error' : '' }}">
                                <div class="col-sm-12">
                                    <input placeholder="Nhập tiêu đề tại đây" id="title" name="title" value="{{ old('title', '') }}" type="text" class="form-control">
                                    @foreach($errors->get('title') as $err)
                                        <label class="error" for="title">{{ $err }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group slug {{ count($errors->get('slug')) > 0 ? 'has-error' : 'hidden' }}">
                                <div class="col-md-12">
                                    <strong>Liên kết tĩnh: </strong>{{ Request::root() }}/<span id="permalink" title="Đường dẫn tĩnh tạm thời. Ấn để sửa phần này.">{{ old('slug', '') }}</span>
                                    <input placeholder="" id="slug" name="slug" value="{{ old('slug', '') }}" type="text" class="form-control" style="display: none">
                                    <button id="btn-editslug" onclick="editpermalink();" type="button" class="btn btn-default btn-xs">Sửa</button>
                                    <button id="btn-okslug" onclick="okpermalink();" type="button" class="btn btn-default btn-xs" style="display: none">Ok</button>
                                    @foreach($errors->get('slug') as $err)
                                        <label class="error" for="slug">{{ $err }}</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-md-12 "><textarea name="content" id="content" rows="10" cols="80">{{ old('content', '') }}</textarea></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Đăng bài viết</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input id="published_at" name="published_at" type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-primary pull-right" type="submit">Lưu thay đổi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chuyên mục</h5>
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
                                    <select name="category_id" class="category form-control">
                                        <option></option>
                                        @foreach($category as $cat)
                                            <option value="{{$cat ->id}}">{{$cat ->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thẻ của bài viết</h5>
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
                                    <select class="tags form-control" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('footer-script')
    <script src="{{URL::asset('js/editor/ckeditor.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'HH:mm - dddd DD/MM/YYYY',
                defaultDate: moment().format()
            });
        });
    </script>
    <script>
        $(".category").select2({
            placeholder: "Chọn một chuyên mục",
            allowClear: true
        });
        $(".tags").select2({
            tags: true
        })
        var flag = true;
        $('#title').on('change', function () {
            var title = $('#title').val();
            if(flag){
                $.ajax({
                    dataType: "json",
                    url: '/admin/posts/getpermalink/' + title,
                    success: function (data) {
                        $('#permalink').text(data.permalink);
                        $('#slug').val(data.permalink);
                    }
                })
                $('.slug').removeClass('hidden');
                flag = false;
            }
        });
        CKEDITOR.replace( 'content' );
        function editpermalink() {
            var text = $('#permalink').text();
            $('#permalink').after().html('<input type="text" name="" id="tmplink" value="' + text + '" >');
            $('#btn-editslug').hide();
            $('#btn-okslug').show()
        }
        function okpermalink() {
            var newlink = $('#tmplink').val();
            $('#permalink').text(newlink);
            $('#btn-okslug').hide()
            $('#btn-editslug').show();
            $('#slug').val(newlink);
        }

        $('button[type="submit"]').click(function(e)
        {
            $('#published_at').val($('#datetimepicker1').data("DateTimePicker").date().format('YYYY-mm-DD hh:mm:ss'));
        })
    </script>

@endsection
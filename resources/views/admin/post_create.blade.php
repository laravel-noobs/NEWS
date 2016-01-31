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
                                <div class="col-md-12">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input id="published_at" name="published_at" type='text' class="form-control" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <button class="btn btn-defaut" type="submit" value="draft">Nháp</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary pull-right" type="submit" value="save">Lưu thay đổi</button>
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
                            <div class="form-group {{ count($errors->get('category_id')) + count($errors->get('cat_name')) +  count($errors->get('cat_slug')) > 0  ? 'has-error' : '' }}">
                                <div class="col-sm-12">
                                    <select id="category_id" name="category_id" class="category form-control">
                                        <option></option>
                                        @if(!empty(old('category_id')))
                                            @foreach($category as $cat)
                                                @if(old('category_id') == $cat['id'])
                                                    <option value="{{ old('category_id') }}" selected="selected">{{ $cat['name'] }}</option>
                                                @else
                                                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                                @endif
                                            @endforeach
                                        @else
                                            @if(!empty(old('category_name')))
                                                <option value="{{ old('category_name') }}" selected="selected" data-select2-tag="true">{{ old('category_name') }}</option>
                                            @endif
                                            @foreach($category as $cat)
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
                                    <select name="tags[]" id="tags" class="tags form-control" multiple="multiple">
                                        @foreach(old('new_tags', []) as $tag)
                                            <option value="{{ $tag['name'] }}" data-select2-tag="true" selected="selected">{{ $tag['name'] }}</option>
                                        @endforeach
                                        @foreach(old('existed_tags', []) as $tag)
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
            tags: true
        });
        $(".category").trigger("change");
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
            $('#tags option[data-select2-tag="true"]').each(function(){
                $(this).val('*-' + $(this).text());
            }); // manually set value to non existed tags
            $('.category option[data-select2-tag="true"]').each(function(){
                $(this).val('*-' + $(this).text());
            }); // manually set value to non existed tags
        })

        $("#tags").select2({
            tags: true,
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
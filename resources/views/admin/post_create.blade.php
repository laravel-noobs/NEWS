<?php
app('navigator')
        ->activate('posts', 'create')
        ->set_page_heading('Tạo bài viết mới')
        ->set_breadcrumb('admin', 'posts', 'post_create');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
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
                    <form method="POST" action=" " class="form-horizontal">
                        <div class="form-group"><label class="col-sm-2 control-label">Tiêu đề</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Chuyên mục</label>

                            <div class="col-sm-10"><select class="form-control m-b" name="account">
                                    @foreach($category as $cat)
                                    <option value="{{$cat ->id}}">{{$cat ->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                         </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label">Thẻ</label>

                            <div class="col-sm-10"><input type="text" class="form-control"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <textarea name="editor" id="editor" rows="10" cols="80">

                            </textarea>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-white">Cancel</button>
                                <button class="btn btn-primary" type="submit">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script src="{{URL::asset('js/editor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
@endsection
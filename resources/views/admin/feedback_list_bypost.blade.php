<?php
app('navigator')
        ->activate('feedbacks', 'index')
        ->set_page_heading('Phản hồi của bài viết')
        ->set_breadcrumb('admin', 'posts', 'feedbacks')
        ->set_page_title($post->title . " - phản hồi" );
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Phản hồi bài viết: </h5><strong class="m-l-sm"><a href="{{ URL::action('PostsController@show', ['id' => $post->id]) }}">{{ $post->title }}</a></strong>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-page-navigation=".footable-pagination">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" width="40%">Nội dung</th>
                            <th data-sort-ignore="true">Người dùng</th>
                            <th data-sort-ignore="true">Ngày nhận</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($post->feedbacks as $feedback)
                        <tr>
                            <td>{{ $feedback->content }}</td>
                            <td>{{ $feedback->user->name }}</td>
                            <td>{{ $feedback->created_at }}</td>
                            <td>
                                <div class="pull-right">
                                    <a class="btn-white btn btn-xs" data-toggle="modal" href="#modal-feedback-prompt">
                                        <i class="fa {{ $feedback->checked ? "fa-check-square-o" : "fa-square-o" }}"></i>
                                        <span> Phản hồi</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                {{--<div class="pull-right">{!! $feedbacks->links() !!}</div>--}}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-feedback-prompt" class="modal fade" aria-hidden="true">
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
    </script>
@endsection
<?php
app('navigator')
        ->activate('products', 'collections')
        ->set_page_heading('Danh sách nhóm sản phẩm')
        ->set_breadcrumb('admin', 'collections')
        ->set_page_title('Danh sách nhóm sản phẩm');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="collection_status" {{ $filter_collection_status == 'all' ? 'checked' : '' }} value="all"> Tất cả
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="collection_status" {{ $filter_collection_status == 'showing' ? 'checked' : '' }} value="showing"> Đang hiển thị
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="collection_status" {{  $filter_collection_status == 'hidden' ? 'checked' : '' }} value="hidden"> Đã ẩn
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="checkbox" name="hide_expired" {{ $filter_hide_expired ? 'checked' : '' }}> Ẩn hết hạn
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Danh sách nhóm sản phẩm</h5>
                    <span class="text-muted small pull-right">{{ $collections->total() }} nhóm</span>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny"  data-page-navigation=".footable-pagination" data-page-size="{{ $collections->perPage() }}">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" data-hide="phone" data-toggle="true"></th>
                            <th data-sort-ignore="true">Tên</th>
                            <th data-sort-ignore="true" data-hide="phone">Mô tả</th>
                            <th data-sort-ignore="true" data-hide="phone">Sản phẩm</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($collections as $collection)
                                <tr>
                                    <td style="width:1%; white-space:nowrap">
                                        @if($collection->image)
                                            <img src="{{ $collection->image }}" style="width: 120px; height: 80px; background: grey" />
                                        @else
                                            <div style="width: 120px; height: 80px; background: grey"></div>
                                        @endif

                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $collection->label }}</strong>
                                        </div>
                                        <div>
                                            {{ $collection->expired_at }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>{{ $collection->description ?: '-' }}</div>

                                        <div><strong>{{ $collection->name }}</strong></div>
                                        <div>
                                            <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">

                                                @can('updateCollection')

                                                    @if(!$collection->enabled)
                                                        <li><a href="{{ URL::action('CollectionsController@unhide', ['id' => $collection->id]) }}">Hiển thị</a></li>
                                                    @else
                                                        <li><a href="{{ URL::action('CollectionsController@hide', ['id' => $collection->id]) }}">Ẩn</a></li>
                                                    @endif

                                                    <li><a href="{{ URL::action('CollectionsController@edit', ['id' => $collection->id]) }}">Sửa</a></li>

                                                @endcan

                                                @can('destroyCollection')
                                                    <li><a data-toggle="modal" href="#modal-collection-delete-prompt" data-collection_label="{{ $collection->label }}" data-collection_id="{{ $collection->id }}" class="text-danger">Xóa</a></li>
                                                @endcan

                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $collection->productsCount }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pull-right">{!! $collections->links() !!}</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('destroyCollection')
    @section('collection-delete_inputs')
        <input name="collection_id" type="hidden"/>
    @endsection
    @include('admin.partials._prompt',[
        'id' => 'collection-delete',
        'method' => 'post',
        'action' => URL::action('CollectionsController@destroy'),
        'title' => 'Xác nhận',
        'message' => 'Bạn có chắc chắn muốn xóa nhãn hiệu "<span class="collection_label">này</span>" hay không?',
    ])
    @endcan
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $('input[name="hide_expired"]').on('ifToggled', function(event){
            $.ajax({
                url: '{{ URL::action('CollectionsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.hide_expired", value: $(this).attr('checked') == 'checked' ? 0 : 1 },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
        $('input[name="collection_status"]').on('ifChecked', function(event){
            $.ajax({
                url: '{{ URL::action('CollectionsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.collection_status", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('#modal-collection-delete-prompt').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('input[name="collection_id"]').val($(e.relatedTarget).data('collection_id'));
            $(e.currentTarget).find('span.collection_label').text($(e.relatedTarget).data('collection_label'));
        });
    </script>

@endsection
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
                                    </td>
                                    <td>
                                        {{ $collection->description ?: '-' }}

                                        <div><strong>{{ $collection->name }}</strong></div>
                                        <div>
                                            <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                                @can('updateCollection')
                                                <li><a href="{{ URL::action('CollectionsController@edit', ['id' => $collection->id]) }}">Sửa</a></li>
                                                @endcan

                                                @can('destroyCollection')
                                                <li><a data-toggle="modal" href="#modal-product-delete-prompt" data-product_label="{{ $collection->label }}" data-collection_id="{{ $collection->id }}" class="text-danger">Xóa</a></li>
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
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
    </script>
@endsection
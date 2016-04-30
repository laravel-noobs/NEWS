<?php
app('navigator')
        ->activate('products', 'index')
        ->set_page_heading('Danh sách sản phẩm')
        ->set_breadcrumb('admin', 'products');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group search-box">
                                <input placeholder="Tìm sản phẩm" id="search-input" type="text" class="form-control input-sm" value="{{ $filter_search_term }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn-white btn btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="category_id" name="category_id" class="category form-control">
                                <option value="NULL">Tất cả danh mục sản phẩm</option>
                                @foreach($categories as $cat)
                                    @if($filter_category == $cat['id'])
                                        <option value="{{ $cat['id'] }}" selected="selected">{{ $cat['name'] }}</option>
                                    @else
                                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'all' ? 'checked' : '' }} value="all"> Tất cả
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'outofstock' ? 'checked' : '' }} value="outofstock"> Hết hàng
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'available' ? 'checked' : '' }} value="available"> Còn hàng
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'disabled' ? 'checked' : '' }} value="disabled"> Vô hiệu
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.shop.partials._product_index_mode_select')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách sản phẩm</h5>

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
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="{{ $products->perPage() }}">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" data-toggle="true"></th>
                            <th data-sort-ignore="true">Tên</th>
                            <th data-sort-ignore="true" data-hide="phone">Mô tả</th>
                            <th data-sort-ignore="true" data-hide="phone" width="10%">Phân loại</th>
                            <th data-sort-ignore="true" data-hide="phone">Phản hồi</th>
                            <th data-sort-ignore="true" data-hide="phone">Bình luận</th>
                            <th data-sort-ignore="true" data-hide="phone">Đánh giá</th>
                            <th data-sort-ignore="true" data-hide="all">Lượt xem</th>
                            <th data-sort-ignore="true" data-hide="all">Ngày đăng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td style="width:1%; white-space:nowrap">
                                    <img src="{{ $product->image }}" style="width:80px; height: 120px; background: grey" />
                                </td>
                                <td>
                                       <div>{{ $product->name }}</div>
                                    <div><strong>{{ $product->status->label }}</strong></div>
                                </td>
                                <td>
                                    {{ $product->description }}
                                    <div>
                                        <ul class="list-inline">
                                            @foreach($product->tags as $tag)
                                                <li><span class="badge">{{ $tag->name }}</span></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                            @if($product->status->name != 'disabled')
                                                @can('disableProduct')
                                                <li><a data-toggle="modal" href="#modal-product-disable-prompt" data-product_name="{{ $product->name }}" data-product_id="{{ $product->id }}" class="text-danger">Vô hiệu</a></li>
                                                @endcan
                                            @else
                                                @can('enableProduct')
                                                <li><a data-toggle="modal" href="#modal-product-enable-prompt" data-product_name="{{ $product->name }}" data-product_id="{{ $product->id }}" class="text-success">Cho phép</a></li>
                                                @endcan
                                            @endif

                                            @can('updateProduct')
                                            <li><a href="{{ URL::action('ProductsController@edit', ['id' => $product->id]) }}">Sửa</a></li>
                                            @endcan

                                            @can('destroyProduct')
                                            <li><a data-toggle="modal" href="#modal-product-delete-prompt" data-product_name="{{ $product->name }}" data-product_id="{{ $product->id }}" class="text-danger">Xóa</a></li>
                                            @endcan
                                        </ul>
                                    </div>

                                </td>
                                <td>
                                    <div>{{ $product->category != null ? $product->category->name : '' }}</div>
                                    <div>{{ $product->brand != null ? $product->brand->name : '' }}</div>
                                </td>
                                <td>
                                    @can('indexFeedback')
                                    <span>{{ $product->feedbacksCount }}</span>
                                    @else
                                        <span>{{ $product->feedbacksCount }}</span>
                                    @endcan
                                </td>
                                <td>{{ $product->commentsCount }}</td>
                                <td>{{ $product->reviewsCount }}</td>
                                <td>{{ $product->view }}</td>
                                <td>{{ $product->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="8">
                                <div class="pull-right">{!! $products->links() !!}</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('destroyProduct')
        @section('product-delete_inputs')
            <input name="product_id" type="hidden"/>
        @endsection
        @include('admin.partials._prompt',[
            'id' => 'product-delete',
            'method' => 'post',
            'action' => URL::action('ProductsController@destroy'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn xóa sản phẩm "<span class="product_name">này</span>" hay không?',
        ])
    @endcan

    @can('enableProduct')
        @section('product-enable_inputs')
            <input name="product_id" type="hidden"/>
        @endsection
        @include('admin.partials._prompt',[
            'id' => 'product-enable',
            'method' => 'post',
            'action' => URL::action('ProductsController@enable'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn cho phép sản phẩm "<span class="product_name">này</span>" hay không?',
        ])
    @endcan

    @can('disableProduct')
        @section('product-disable_inputs')
            <input name="product_id" type="hidden"/>
        @endsection
        @include('admin.partials._prompt',
        [
            'id' => 'product-disable',
            'method' => 'post',
            'action' => URL::action('ProductsController@disable'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn vô hiệu sản phẩm "<span class="product_name">này</span>" hay không?',
        ])
    @endcan
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });

        $(".category").select2({
            placeholder: "Lọc theo danh mục sản phẩm",
            tags: true
        });

        $('#modal-product-delete-prompt, #modal-product-disable-prompt, #modal-product-enable-prompt').on('show.bs.modal', function(e) {
            product_id = $(e.relatedTarget).data('product_id');
            product_name = $(e.relatedTarget).data('product_name');
            $(e.currentTarget).find('input[name="product_id"]').val(product_id);
            $(e.currentTarget).find('span.product_name').html('<strong>' + product_name + '</strong>');
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-gree',
            radioClass: 'iradio_square-green'
        });

        $('input[name="status_type"]').on('ifChecked', function(event){
            $.ajax({
                url: '{{ URL::action('ProductsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.status_type", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('select[name="category_id"]').on("select2:select", function (e) {
            cat_id = $(e.currentTarget).val();
            $.ajax({
                url: '{{ URL::action('ProductsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.category", value: cat_id === '*' ? 'NULL' : cat_id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('.search-box button').on('click', function(){
            box = $(this).parents('.search-box');
            $.ajax({
                url: '{{ URL::action('ProductsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.search_term", value: box.find('#search-input').val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>
@endsection


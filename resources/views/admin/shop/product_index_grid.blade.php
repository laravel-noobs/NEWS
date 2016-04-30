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
                <div class="ibox-content">
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

    @include('admin.shop.partials._product_index_mode_select', compact('index_mode'))

    <div class="row">
        <div class="col-lg-12">
            @for($i = 0; $i < count($products);)
                @if($i % 4 == 0)
                    <div class="row">
                @endif
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
                            <form>
                                <input type="hidden" name="product_id" value="{{ $products[$i]->id }}">
                                <div class="product-imitation xl">
                                    <div class="product-thumbnail center-block">
                                        <img src="{{ $products[$i]->image }}" class="img-responsive" />
                                        <div class="product-overlay">
                                            <span class="inline">[INFO]</span>
                                            <div class="triangle" style="float:left"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-desc">
                                    <span class="product-price">
                                        {{ $products[$i]->price }}
                                    </span>
                                    <div>
                                        <small class="text-muted">{{ $products[$i]->brand != null ? $products[$i]->brand->name : '' }}</small>
                                        <small class="text-muted pull-right">{{ $products[$i]->category != null ? $products[$i]->category->name : '' }}</small>
                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="hidden" name="product_name" value="{{ $products[$i]->name }}">
                                    <a href="#" class="product-name"> {{ $products[$i]->name }}</a>

                                    <div class="small m-t-xs">
                                        {{ $products[$i]->description }}
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-7 m-t">
                                            <div class="input-group input-group-xs text-righ">
                                                <input type="text" name="quantity" class="form-control input-xs" />
                                                <span class="input-group-btn">
                                                    <button class="order btn btn-xs btn-outline btn-primary">
                                                        <i class="fa fa-shopping-cart"></i> Order
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xs-5 m-t">
                                            <ul class="list-inline action" style="padding-top: 3px; margin-bottom: 0;">
                                                @if($products[$i]->status->name != 'disabled')
                                                    @can('disableProduct')
                                                    <li>
                                                        <a data-toggle="modal" href="#modal-product-disable-prompt" data-product_name="{{ $products[$i]->name }}" data-product_id="{{ $products[$i]->id }}" class="text-danger">
                                                            <i class="fa fa-eye-slash"></i>
                                                        </a>
                                                    </li>
                                                    @endcan
                                                @else
                                                    @can('enableProduct')
                                                    <li><a data-toggle="modal" href="#modal-product-enable-prompt" data-product_name="{{ $products[$i]->name }}" data-product_id="{{ $products[$i]->id }}" class="text-success">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </li>
                                                    @endcan
                                                @endif

                                                @can('updateProduct')
                                                <li>
                                                    <a href="{{ URL::action('ProductsController@edit', ['id' => $products[$i]->id]) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </li>
                                                @endcan

                                                @can('destroyProduct')
                                                <li><a data-toggle="modal" href="#modal-product-delete-prompt" data-product_name="{{ $products[$i]->name }}" data-product_id="{{ $products[$i]->id }}" class="text-danger">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if(++$i % 4 == 0)
                    </div>
                @endif
            @endfor
        </div>

        <div class="col-lg-12">
            <div>{!! $products->links() !!}</div>
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

        $('.btn.order').on('click', function(e) {
            e.preventDefault();
            data = $(this).parents('.product-box > form').serializeArray();
            $.ajax({
                url: '{{ URL::action('OrdersController@postConfig') }}',
                method: 'post',
                data: { 'merge': '1', name: "order", value: [{'product_id' : data[0].value, 'quantity': data[2].value }] },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).success(function() {
                toastr['success']('Thành công thêm sản phẩm "' + data[1].value + '" vào đơn đặt hàng mới.', "Đơn đặt hàng mới");
            });
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


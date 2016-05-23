<?php
app('navigator')
        ->activate('orders', 'create')
        ->set_page_heading('Lập đơn đặt hàng')
        ->set_breadcrumb('admin', 'orders', 'order_create')
        ->set_page_title('Lập đơn đặt hàng');
?>

@extends('partials.admin._layout')

@section('content')
    @if($errors->count())
    <div class="row" class="bg-danger">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" style="margin-bottom: 0px">
                <div class="ibox-content">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li class="error">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Đơn đặt hàng mới</h5>
                    <div class="ibox-tools">
                        <button id="refresh-detail" class="control-detail btn btn-xs btn-outline btn-primary">
                            <i class="fa fa-refresh"></i> Làm tươi
                        </button>

                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <p>
                        Lập đơn đặt hàng mới theo từng bước
                    </p>
                    <form id="wizard" method="post" action="{{ URL::action('OrdersController@store') }}">
                        {{ csrf_field() }}
                        <h1>Chi tiết</h1>
                        <fieldset>
                            <h2>Chi tiết đơn đặt hàng</h2>

                            @foreach($errors->get('items') as $err)
                                <label class="error">{{ $err }}</label>
                            @endforeach

                            <strong>Sản phẩm:</strong>
                            <ul id="detail-text">
                                @foreach($order_product as $op)
                                <li>
                                    <div class="product_name">{{ $op->product->name }}</div>
                                    <div>
                                        <span class="quantity">{{ $op->quantity }}</span> x <span class="product_price price">{{ $op->product->price }}</span> = <strong class="price"> {{ $op->quantity * $op->product->price }}</strong>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <br/>
                            <strong>Thành tiền:</strong> <span class="text-navy total-price price">0</span>
                            <p class="m-t">
                                Ấn làm tươi và kiểm tra đơn đặt hàng trước khi tiếp tục.
                            </p>
                        </fieldset>


                        <h1>Giao hàng</h1>
                        <fieldset>
                            <h2>Địa chỉ giao hàng</h2>
                            <div class="form-group">
                                <label for="user_id">Người dùng</label>
                                <div style="width:100%">
                                    <select id="user_id" name="user_id" class="form-control" aria-required="true">
                                    </select>
                                </div>
                                @foreach($errors->get('user_id') as $err)
                                    <label class="error" for="user_id">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="customer_name">Name</label>
                                <div>
                                    <input id="customer_name" name="customer_name" type="text" class="form-control required" aria-required="true">
                                </div>
                                @foreach($errors->get('customer_name') as $err)
                                    <label class="error" for="customer_name">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <div>
                                    <input id="email" name="email" type="email" class="form-control required email" aria-required="true">
                                </div>
                                @foreach($errors->get('email') as $err)
                                    <label class="error" for="email">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="province">Tỉnh/Thành phố</label>
                                <div>
                                    <select id="province" class="form-control required" aria-required="true">
                                        <option value="" selected>Chọn tỉnh/thành phố</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="district">Huyện/Quận/Thị xã</label>
                                <div>
                                    <select id="district" class="form-control required" aria-required="true">
                                        <option value="" selected>Chọn huyện/quận/thị xã</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ward">Xã/Phường/Thị trấn</label>
                                <div>
                                    <select id="ward" name="delivery_ward_id" class="form-control required" aria-required="true">
                                        <option value="" selected>Chọn xã/phường/thị trấn</option>
                                    </select>
                                </div>
                                @foreach($errors->get('delivery_ward_id') as $err)
                                    <label class="error" for="ward">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="delivery_address required">Địa chỉ</label>
                                <div>
                                    <input id="delivery_address" name="delivery_address" type="text" class="form-control required" aria-required="true">
                                </div>
                                @foreach($errors->get('delivery_address') as $err)
                                    <label class="error" for="delivery_address">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="phone required">Điện thoại</label>
                                <div>
                                    <input id="phone" name="phone" type="text" class="form-control required" aria-required="true">
                                </div>
                                @foreach($errors->get('phone') as $err)
                                    <label class="error" for="phone">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="delivery_note">Ghi chú</label>
                                <div>
                                    <textarea rows="8" id="delivery_note" name="delivery_note" class="form-control"></textarea>
                                </div>
                                @foreach($errors->get('delivery_note') as $err)
                                    <label class="error" for="delivery_note">{{ $err }}</label>
                                @endforeach
                            </div>
                        </fieldset>

                        <h1>Thanh toán</h1>
                        <fieldset>
                            <h2>Chọn hình thức thanh toán</h2>
                            <div class="panel-group payments-method" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="pull-right">
                                        </div>
                                        <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#direct_method">
                                                Trực tiếp
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="direct_method" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <p class="m-t">
                                                        Khách hàng trả tiền trực tiếp tại địa chỉ nhận hàng.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="panel panel-default">--}}
                                    {{--<div class="panel-heading">--}}
                                        {{--<div class="pull-right">--}}
                                            {{--<i class="fa fa-cc-paypal text-success"></i>--}}
                                        {{--</div>--}}
                                        {{--<h5 class="panel-title">--}}
                                            {{--<a data-toggle="collapse" data-parent="#accordion" href="#paypal_method">Paypal</a>--}}
                                        {{--</h5>--}}
                                    {{--</div>--}}
                                    {{--<div id="paypal_method" class="panel-collapse collapse">--}}
                                        {{--<div class="panel-body">--}}

                                            {{--<div class="row">--}}
                                                {{--<div class="col-md-10">--}}
                                                    {{--<p class="m-t">--}}
                                                        {{--Hình thức thanh toán này chưa hỗ trợ.--}}
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="panel panel-default">--}}
                                    {{--<div class="panel-heading">--}}
                                        {{--<div class="pull-right">--}}
                                            {{--<i class="fa fa-cc-visa text-info"></i>--}}
                                            {{--<i class="fa fa-cc-amex text-success"></i>--}}
                                            {{--<i class="fa fa-cc-mastercard text-warning"></i>--}}
                                            {{--<i class="fa fa-cc-discover text-danger"></i>--}}
                                        {{--</div>--}}
                                        {{--<h5 class="panel-title">--}}
                                            {{--<a data-toggle="collapse" data-parent="#accordion" href="#card_method">Thẻ</a>--}}
                                        {{--</h5>--}}
                                    {{--</div>--}}
                                    {{--<div id="card_method" class="panel-collapse collapse in">--}}
                                        {{--<div class="panel-body">--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-12">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<label>MÃ THẺ</label>--}}
                                                        {{--<div class="input-group">--}}
                                                            {{--<input type="text" class="form-control" name="card_number" placeholder="Valid Card Number" required />--}}
                                                            {{--<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>--}}
                                                        {{--</div>--}}
                                                        {{--@foreach($errors->get('card_number') as $err)--}}
                                                            {{--<label class="error" for="card_number">{{ $err }}</label>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-7 col-md-7">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<label>NGÀY HẾT HẠN</label>--}}
                                                        {{--<input type="text" class="form-control required" name="card_expiry" placeholder="MM / YY" />--}}
                                                        {{--@foreach($errors->get('card_expiry') as $err)--}}
                                                            {{--<label class="error" for="card_expiry">{{ $err }}</label>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="col-xs-5 col-md-5 pull-right">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<label>MÃ CV</label>--}}
                                                        {{--<input type="text" class="form-control required" name="card_cvc" placeholder="CVC" />--}}
                                                        {{--@foreach($errors->get('card_cvc') as $err)--}}
                                                            {{--<label class="error" for="card_cvc">{{ $err }}</label>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="row">--}}
                                                {{--<div class="col-xs-12">--}}
                                                    {{--<div class="form-group">--}}
                                                        {{--<label>TÊN CHỦ THẺ</label>--}}
                                                        {{--<input type="text" class="form-control required" name="card_name" placeholder="NAME AND SURNAME"/>--}}
                                                        {{--@foreach($errors->get('card_name') as $err)--}}
                                                            {{--<label class="error" for="card_name">{{ $err }}</label>--}}
                                                        {{--@endforeach--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<h1 class="text-danger"><strong>DO NOT MAKE PAYMENT VIA NON-SECURE CONNECTION</strong></h1>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="ibox float-e-margins">
                <div class="ibox-content m-b-sm border-bottom">
                    <div>
                        <span>Vui lòng thêm ở trang <a target="_blank" href="{{ URL::action('ProductsController@index') }}">danh sách sản phẩm</a>.</span>
                        <span class="pull-right">
                            <button class="control-detail update-all btn btn-xs btn-outline btn-primary">
                                <i class="fa fa-refresh"></i> Cập nhật tất cả
                            </button>
                            <button class="control-detail clear-all btn btn-xs btn-outline btn-danger">
                                <i class="fa fa-times"></i> Xóa tất cả
                            </button>
                        </span>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <table id="detail" class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="{{ count($order_product) }}">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true" data-toggle="true"></th>
                            <th data-sort-ignore="true">Tên</th>
                            <th data-sort-ignore="true" width="20%">Số lượng</th>
                            <th data-sort-ignore="true" width="20%" data-hide="phone" width="10%">Phân loại</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order_product as $op)
                            <tr id="product-{{ $op->product->id }}">
                                <td style="width:1%; white-space:nowrap">
                                    <img src="{{ $op->product->image }}" style="width:80px; height: 120px; background: grey" />
                                </td>
                                <td>
                                    <div class="product_name">{{ $op->product->name }}</div>
                                    <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                        <li>
                                            <a data-product_id="{{ $op->product->id }}" class="remove text-danger">Xóa khỏi đơn hàng</a>
                                        </li>
                                    </ul>
                                    <div><strong class="status_label">{{ $op->product->status->label }}</strong></div>
                                </td>
                                <td width="20%">
                                    <div class="input-group input-group-xs text-right">
                                        <input style="width:60px" type="number" name="quantity" class="form-control input-xs" value="{{ $op->quantity }}" />
                                        <span class="input-group-btn">
                                            <button data-product_id="{{ $op->product->id }}" class="control-detail update btn btn-xs btn-outline btn-primary">
                                                <i class="fa fa-refresh"></i> Cập nhật
                                            </button>
                                        </span>
                                    </div>
                                    <div><strong>Đơn giá</strong>: <span class="product_price">{{ $op->product->price }}</span></div>
                                </td>
                                <td width="20%">
                                    <div class="category_name">{{ $op->product->category != null ? $op->product->category->name : '' }}</div>
                                    <div class="brand_name">{{ $op->product->brand != null ? $op->product->brand->name : '' }}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="hr-line-dashed"></div>
                    <div class="clearfix">
                        <span class="pull-right">
                            <button class="control-detail update-all btn btn-xs btn-outline btn-primary">
                                <i class="fa fa-refresh"></i> Cập nhật tất cả
                            </button>
                            <button class="control-detail clear-all btn btn-xs btn-outline btn-danger">
                                <i class="fa fa-times"></i> Xóa tất cả
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('footer-script')

    <script>
        var detail_template = '<tr> <td style="width:1%; white-space:nowrap"> <img src="" style="width:80px; height: 120px; background: grey" /> </td> <td> <div class="product_name"></div><ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;"> <li> <a class="remove text-danger">Xóa khỏi đơn hàng</a> </li> </ul> <div><strong class="status_label"></strong></div> </td> <td width="20%"> <div class="input-group input-group-xs text-righ"> <input style="width:60px" type="number" name="quantity" class="form-control input-xs" value="" /> <span class="input-group-btn"> <button class="control-detail update btn btn-xs btn-outline btn-primary"> <i class="fa fa-refresh"></i> Cập nhật </button> </span> </div> <div><strong>Đơn giá</strong>: <span class="product_price price"></span></div> </td> <td width="20%"> <div class="category_name"></div> <div class="brand_name"></div> </td> </tr>';
        var detail_text_template = '<li><div class="product_name"></div><div><span class="quantity"></span> x <span class="product_price price"></span> = <strong class="price"></strong></div> </li>';
        $(document).ready(function(){
            form = $("#wizard");
            form.steps({
                labels: {
                    cancel: "Hủy",
                    current: "bước hiện tại:",
                    pagination: "Phân trang",
                    finish: "Hoàn tất",
                    next: "Tiếp theo",
                    previous: "Quay lại",
                    loading: "Đang tải ..."
                },
                transitionEffect: "slideLeft",
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex) return true;

                    if (currentIndex === 0 && $('ul#detail-text > li').length == 0)return false;

                    if (currentIndex === 1)
                    {
                        var form = $(this);
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    }

                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");

                    return true;
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {

                },
                onFinishing: function (event, currentIndex)
                {


                    var paymentMethod = $('.panel-collapse.collapse.in').attr('id');

                    if(paymentMethod === undefined || paymentMethod === 'paypal_method')
                        return false;

                    if(paymentMethod === 'direct_method')
                    {
                        $(this).find('input[name="card_number"]').attr('disabled', 'disabled');
                        $(this).find('input[name="card_name"]').attr('disabled', 'disabled');
                        $(this).find('input[name="card_cvc"]').attr('disabled', 'disabled');
                        $(this).find('input[name="card_expiry"]').attr('disabled', 'disabled');
                        return true;
                    }

                    if(paymentMethod === 'card_method')
                    {
                        $(this).find('input[name="card_number"]').removeAttr('disabled');
                        $(this).find('input[name="card_name"]').removeAttr('disabled');
                        $(this).find('input[name="card_cvc"]').removeAttr('disabled');
                        $(this).find('input[name="card_expiry"]').removeAttr('disabled');
                        var form = $(this);
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    }
                },
                onFinished: function (event, currentIndex)
                {
                    var paymentMethod = $('.panel-collapse.collapse.in').attr('id');
                    $(this).append('<input type="hidden" name="paymentMethod" value="' + paymentMethod + '">');
                    var items = [];
                    $('table tbody tr').each(function(i, l) {
                        console.log(i); console.log(l);
                        product_id_name = 'items[' + i + '][product_id]';
                        quantity_name = 'items[' + i + '][quantity]';
                        product_id = $(l).attr('id').substring(8);
                        quantity = $(l).find('input[name="quantity"]').val();
                        items[product_id_name] = product_id;
                        items[quantity_name] = quantity;
                    });
                    console.log(items);
                    var template = jQuery.parseHTML('<ul id="temp_detail"></ul>');
                    for (var key in items)
                    {
                            var template_item = jQuery.parseHTML('<input type="hidden" value="" name="">');
                            $(template_item).attr('name', key).attr('value', items[key]);
                            $(template).append(template_item);
                    }

                    $(this).find('#temp_detail').remove();

                    $(this).append(template).submit();

                }
            });
            $('.footable').footable();

            $("#user_id").select2({
                allowClear: true,
                placeholder: "Chọn một người dùng",
                ajax: {
                    url: '/admin/users/search?query=' + $(this).val(),
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
                width: '100%',
                escapeMarkup: function (markup) { return markup; },
                minimumInputLength: 3,
                templateResult: function (item) {
                    if (item.loading) return item.text;
                    markup = '<div><span>' + item.text + '</span></div>';
                    return markup;
                },
                templateSelection: function (item) {
                    return '<option style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
                }
            }).change(function(){
                $.ajax({
                    url: '/admin/users/info?user_id=' + $(this).val(),
                    method: 'get'
                }).done(function(data) {
                    $('#customer_name').val(data.last_name + ' ' + data.first_name);
                    //$('#customer_name').val(data.first_name + ' ' + data.last_name);
                    $('#delivery_address').val(data.delivery_address);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    if(data.delivery_ward != null)
                    {
                        $('#province').val(data.delivery_ward.district.province.id).trigger('change');
                        $('#district').data('prefer', data.delivery_ward.district.id);
                        $('#ward').data('prefer', data.delivery_ward.id);
                    } else {
                        $('#province').val('').trigger('change');
                    }
                });
            });

            $('#district').change(function() {
                $.ajax({
                    url: '/division/' + $(this).val() + '/wards',
                    method: 'get'
                }).done(function(data) {
                    ward = $('#ward').html('');
                    for(i = 0; i < data.length; i++)
                    {
                        if(ward.data('prefer') ==  data[i].id)
                            ward.append('<option selected="selected" value="' + data[i].id + '">' + data[i].name + ' (' + data[i].type.name + ')' + '</option>')
                        else
                            ward.append('<option value="' + data[i].id + '">' + data[i].name + ' (' + data[i].type.name + ')' + '</option>')
                    }
                });
            });

            $('#province').change(function() {
                if($(this).val() == '')
                {
                    $('#district').html('<option value="" selected>Chọn huyện/quận/thị xã</option>');
                    $('#ward').html('<option value="" selected>Chọn xã/phường/thị trấn</option>');
                    return;
                }
                $.ajax({
                    url: '/division/' + $(this).val() + '/districts',
                    method: 'get'
                }).done(function(data) {
                    district = $('#district').html('');
                    for(i = 0; i < data.length; i++)
                    {
                        if(district.data('prefer') ==  data[i].id)
                            district.append('<option selected="selected" value="' + data[i].id + '">' + data[i].name + ' (' + data[i].type.name + ')' + '</option>')
                        else
                            district.append('<option value="' + data[i].id + '">' + data[i].name + ' (' + data[i].type.name + ')' + '</option>')
                    }

                    district.trigger('change');
                });
            }).trigger('change');

        });

        $('.clear-all').on('click', function() {
            $('.control-detail').attr('disabled', 'disabled');
            $.ajax({
                url: '{{ URL::action('OrdersController@clearDetails') }}',
                method: 'get'
            }).done(function(data) {
                refreshDetail(data);
                $('.control-detail').removeAttr('disabled');
            });
        });

        $('#refresh-detail').on('click', function() {
            $('.control-detail').attr('disabled', 'disabled');
            $.ajax({
                url: '{{ URL::action('OrdersController@detail') }}',
                method: 'get'
            }).done(function(data) {
                refreshDetail(data);
                $('.control-detail').removeAttr('disabled');
            });
        });

        $('.control-detail.update').on('click', function() { updateDetail(this) });
        $('a.remove').on('click', function() { removeDetail(this); });

        $('.control-detail.update-all').on('click', function() {
            $('.control-detail').attr('disabled', 'disabled');
            var details = {};
            var i = 0;
            $('table tbody tr').each(function( i, l ){
                details[i++] = {
                    'product_id': $(l).attr('id').replace('product-',''),
                    'quantity': $(l).find('input[name="quantity"]').val()
                };
            });

            $.ajax({
                url: '{{ URL::action('OrdersController@updateDetails') }}',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { details: details },
                statusCode: {
                    400: function (jqXHR, textStatus, errorThrown) {
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function(data) {
                refreshDetail(data);
                $('.control-detail').removeAttr('disabled');
            });
        });

        function updateDetail(button){
            product_id = $(button).data('product_id');
            $(button).attr('disabled', 'disabled');
            quantity = $('#product-' + product_id).find('input[name="quantity"]').val();
            $.ajax({
                url: '{{ URL::action('OrdersController@updateDetail') }}',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'product_id': product_id, 'quantity': quantity},
                statusCode: {
                    400: function (jqXHR, textStatus, errorThrown) {
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function(data) {
                $(button).removeAttr('disabled');
            });
        }
        function removeDetail(button)
        {
            product_id = $(button).data('product_id');
            $(button).attr('disabled', 'disabled');
            $.ajax({
                url: '{{ URL::action('OrdersController@removeDetail') }}',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {'product_id': product_id},
                statusCode: {
                    400: function (jqXHR, textStatus, errorThrown) {
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function(data) {
                $(button).removeAttr('disabled');
                if(data.return == true)
                {
                    $(button).parents('tr').remove();
                    $('table').trigger('footable_initialize');
                }
            });
        }

        function refreshDetail(data)
        {
            var footable = $('table').data('footable');
            var rows = $('#detail > tbody tr');
            for(i = 0; i < rows.length; i++)
                $('table tbody tr').remove();


            detail_text = $('ul#detail-text');
            detail_text.html('');

            total_price = $('.total-price');
            total_price.html('0');
            total = 0;

            for(i = 0; i < data.length; i++)
            {
                var template = jQuery.parseHTML(detail_template);
                $(template).attr('id', 'product-' + data[i].product.id);
                $(template).find('input[name=quantity]').val(data[i].quantity);
                $(template).find('img').attr('src', data[i].product.image);
                $(template).find('.product_name').html(data[i].product.name);
                $(template).find('.status_label').html(data[i].product.status.label);
                $(template).find('.product_price').html(data[i].product.price);
                $(template).find('.category_name').html(data[i].product.category != null ? data[i].product.category.name : '');
                $(template).find('.brand_name').html(data[i].product.brand != null ? data[i].product.brand.name : '');
                $(template).find('a.remove')
                        .data('product_id', data[i].product.id)
                        .on('click', function() { removeDetail(this); });
                $(template).find('.control-detail.update')
                        .data('product_id', data[i].product.id)
                        .on('click', function() { updateDetail(this) });

                $(template).find('.price').each(function(){
                    $(this).text(addCommas($(this).text()));
                });

                $('table tbody').append(template);
                $('table').trigger('footable_initialize');
                //footable.appendRow(template);

                template = jQuery.parseHTML(detail_text_template);
                $(template).find('.product_name').html(data[i].product.name);
                $(template).find('.quantity').html(data[i].quantity);
                $(template).find('.product_price').html(data[i].product.price);
                tprice = data[i].quantity * data[i].product.price;
                $(template).find('.price').html(tprice);

                $(template).find('.price').each(function(){
                    $(this).text(addCommas($(this).text()));
                });

                detail_text.append(template);

                total += tprice;
            }
            total_price.html(total);
            total_price.text(addCommas(total_price.text()));
        }
    </script>

@endsection


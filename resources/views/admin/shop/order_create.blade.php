<?php
app('navigator')
        ->activate('orders', 'create')
        ->set_page_heading('Lập đơn đặt hàng')
        ->set_breadcrumb('admin', 'orders', 'order_create')
        ->set_page_title('Lập đơn đặt hàng');
?>

@extends('partials.admin._layout')

@section('content')

    <div class="row">
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Đơn đặt hàng mới</h5>
                    <div class="ibox-tools">
                        <button id="refresh-detail" class="btn btn-xs btn-outline btn-primary">
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
                    <form>
                        <div id="wizard">
                            <h1>Chi tiết</h1>
                            <div class="step-content">
                                <div>
                                    <h2>Chi tiết đơn đặt hàng</h2>
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
                                </div>
                            </div>

                            <h1>Giao hàng</h1>
                            <div class="step-content">
                                <h2>Địa chỉ giao hàng</h2>

                                <div class="form-group">
                                    <label for="user_id">Người dùng</label>
                                    <div style="width:100%">
                                        <select id="user_id" name="user_id" class="form-control">

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div>
                                        <div><input id="email" type="text" class="form-control"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="province">Tỉnh/Thành phố</label>
                                    <div>
                                        <select id="province" class="form-control">
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="district">Huyện/Quận/Thị xã</label>
                                    <div>
                                        <select id="district" class="form-control">
                                            <option>dummy</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="ward">Xã/Phường/Thị trấn</label>
                                    <div>
                                        <select id="ward" id="ward" class="form-control">
                                            <option>dummy</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="delivery_address">Địa chỉ</label>
                                    <div><input id="delivery_address" type="text" class="form-control"></div>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Điện thoại</label>
                                    <div><input id="phone" type="text" class="form-control"></div>
                                </div>

                                <div class="form-group">
                                    <label for="delivery_note">Ghi chú</label>
                                    <div>
                                        <textarea id="delivery_note" rows="8" type="text" class="form-control"></textarea>
                                    </div>
                                </div>

                            </div>

                            <h1>Thanh toán</h1>
                            <div class="step-content">
                                <h2>Chọn hình thức thanh toán</h2>
                                <div class="panel-group payments-method" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-right">
                                                <i class="fa fa-cc-paypal text-success"></i>
                                            </div>
                                            <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#directMethod">
                                                    Trực tiếp
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="directMethod" class="panel-collapse collapse">
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

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-right">
                                                <i class="fa fa-cc-paypal text-success"></i>
                                            </div>
                                            <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#paypalMethod">Paypal</a>
                                            </h5>
                                        </div>
                                        <div id="paypalMethod" class="panel-collapse collapse">
                                            <div class="panel-body">

                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <p class="m-t">
                                                            Hình thức thanh toán này chưa hỗ trợ.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="pull-right">
                                                <i class="fa fa-cc-visa text-info"></i>
                                                <i class="fa fa-cc-amex text-success"></i>
                                                <i class="fa fa-cc-mastercard text-warning"></i>
                                                <i class="fa fa-cc-discover text-danger"></i>
                                            </div>
                                            <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#cardMethod">Thẻ</a>
                                            </h5>
                                        </div>
                                        <div id="cardMethod" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <form role="form" id="payment-form">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label>MÃ THẺ</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="Number" placeholder="Valid Card Number" required />
                                                                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-7 col-md-7">
                                                            <div class="form-group">
                                                                <label>NGÀY HẾT HẠN</label>
                                                                <input type="text" class="form-control" name="Expiry" placeholder="MM / YY"  required/>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-5 col-md-5 pull-right">
                                                            <div class="form-group">
                                                                <label>MÃ CV</label>
                                                                <input type="text" class="form-control" name="CVC" placeholder="CVC"  required/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label>TÊN CHỦ THẺ</label>
                                                                <input type="text" class="form-control" name="nameCard" placeholder="NAME AND SURNAME"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h1 class="text-danger"><strong>DO NOT MAKE PAYMENT VIA NON-SECURE CONNECTION</strong></h1>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="ibox float-e-margins">
                <div class="ibox-content m-b-sm border-bottom">
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
                            <tr>
                                <td style="width:1%; white-space:nowrap">
                                    <img src="{{ $op->product->image }}" style="width:80px; height: 120px; background: grey" />
                                </td>
                                <td>
                                    <div class="product_name">{{ $op->product->name }}</div>
                                    <div><strong class="status_label">{{ $op->product->status->label }}</strong></div>
                                </td>
                                <td width="20%">
                                    <div class="input-group input-group-xs text-righ">
                                        <input style="width:60px" type="number" name="quantity" class="form-control input-xs" value="{{ $op->quantity }}" />
                                        <span class="input-group-btn">
                                            <button class="order btn btn-xs btn-outline btn-primary">
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
                    @if($order_product->count() == 0)
                        <div class="hr-line-dashed"></div>
                        <div><span>Không có sản phẩm nào, vui lòng thêm ở trang <a href="{{ URL::action('ProductsController@index') }}">danh sách sản phẩm</a>.</span></div>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection

@section('footer-script')

    <script>
        var detail_template = '<tr> <td style="width:1%; white-space:nowrap"> <img src="" style="width:80px; height: 120px; background: grey" /> </td> <td> <div class="product_name"></div> <div><strong class="status_label"></strong></div> </td> <td width="20%"> <div class="input-group input-group-xs text-righ"> <input style="width:60px" type="number" name="quantity" class="form-control input-xs" value="" /> <span class="input-group-btn"> <button class="order btn btn-xs btn-outline btn-primary"> <i class="fa fa-refresh"></i> Cập nhật </button> </span> </div> <div><strong>Đơn giá</strong>: <span class="product_price price"></span></div> </td> <td width="20%"> <div class="category_name"></div> <div class="brand_name"></div> </td> </tr>';
        var detail_text_template = '<li><div class="product_name"></div><div><span class="quantity"></span> x <span class="product_price price"></span> = <strong class="price"></strong></div> </li>';
        $(document).ready(function(){
            $("#wizard").steps();
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
                    console.log(data);
                    $('#delivery_address').val(data.delivery_address);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    if(data.delivery_ward != null)
                    {
                        $('#province').val(data.delivery_ward.district.province.id).trigger('change');
                        $('#district').data('prefer', data.delivery_ward.district.id);
                        $('#ward').data('prefer', data.delivery_ward.id);
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

        $('#refresh-detail').on('click', function() {
            $(this).attr('disabled', 'disabled');
            $.ajax({
                url: '{{ URL::action('OrdersController@detail') }}',
                method: 'get'
            }).done(function(data) {
                refreshDetail(data);
                $('#refresh-detail').removeAttr('disabled');
            });
        });

        function refreshDetail(data)
        {
            var footable = $('table').data('footable');
            var rows = $('#detail > tbody tr');
            for(i = 0; i < rows.length; i++)
                footable.removeRow(rows[i]);

            detail_text = $('ul#detail-text');
            detail_text.html('');

            total_price = $('.total-price');
            total_price.html('0');
            total = 0;

            for(i = 0; i < data.length; i++)
            {
                template = jQuery.parseHTML(detail_template);
                $(template).find('input[name=quantity]').val(data[i].quantity);
                $(template).find('img').attr('src', data[i].product.image);
                $(template).find('.product_name').html(data[i].product.name);
                $(template).find('.status_label').html(data[i].product.status.label);
                $(template).find('.product_price').html(data[i].product.price);
                $(template).find('.category_name').html(data[i].product.category != null ? data[i].product.category.name : '');
                $(template).find('.brand_name').html(data[i].product.brand != null ? data[i].product.brand.name : '');

                $(template).find('.price').each(function(){
                    $(this).text(addCommas($(this).text()));
                });

                footable.appendRow(template);

                template = jQuery.parseHTML(detail_text_template);
                $(template).find('.product_name').html(data[i].product.name);
                $(template).find('.quantity').html(data[i].quantity);
                $(template).find('.product_price').html(data[i].product.price);
                tprice = data[i].quantity * data[i].product.price;
                $(template).find('.price').html(tprice);

                $(template).find('.price').each(function(){
                    $(this).text(addCommas($(this).text()));
                });

                detail_text
                        .append(template);

                total += tprice;
            }
            total_price.html(total);
            total_price.text(addCommas(total_price.text()));
        }
    </script>

@endsection


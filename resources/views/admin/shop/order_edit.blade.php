<?php
app('navigator')
        ->activate('orders', 'edit')
        ->set_page_heading('Sửa đơn đặt hàng')
        ->set_breadcrumb('admin', 'orders', 'order_edit')
        ->set_page_title('Sửa đơn đặt hàng');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Sửa thông tin đơn đặt hàng</h3>
                    <form method="POST">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('customer_name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên khách hàng</label>
                            <input type="text" id="customer_name" name="customer_name" placeholder="" value="{{ old('customer_name', $order->customer_name) }}" class="form-control">
                            <span class="help-block m-b-none"></span>
                            @foreach($errors->get('customer_name') as $err)
                                <label class="error" for="customer_name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('email')) > 0 ? 'has-error' : '' }}">
                            <label class="">Email</label>
                            <input type="email" id="email" name="email" placeholder="" value="{{ old('email', $order->email) }}" class="form-control">
                            <span class="help-block m-b-none">Địa chỉ email của khách hàng</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('phone')) > 0 ? 'has-error' : '' }}">
                            <label>Số điện thoại</label>
                            <input type="text" id="phone" name="phone" placeholder="" value="{{ old('phone', $order->phone) }}" class="form-control">
                            <span class="help-block m-b-none">Số điện thoại liên hệ với đơn đặt hàng này</span>
                            @foreach($errors->get('phone') as $err)
                                <label class="error" for="phone">{{ $err }}</label>
                            @endforeach
                        </div>

                        @if($order->isDeliveryInfomationChangable())
                            <div class="form-group">
                                <label for="province">Tỉnh/Thành phố</label>
                                <div>
                                    <select id="province" class="form-control required" aria-required="true">
                                        <option value="" selected>Chọn tỉnh/thành phố</option>
                                        @foreach($provinces as $province)
                                            @if($province->id == $order->delivery_ward->district->province_id)
                                                <option selected="selected" value="{{ $province->id }}">{{ $province->name }}</option>
                                            @else
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="district">Huyện/Quận/Thị xã</label>
                                <div>
                                    <select id="district" data-prefer="{{ $order->delivery_ward->district_id }}" class="form-control required" aria-required="true">
                                        <option value="" selected>Chọn huyện/quận/thị xã</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ward">Xã/Phường/Thị trấn</label>
                                <div>
                                    <select id="ward" data-prefer="{{ $order->delivery_ward_id }}" name="delivery_ward_id" class="form-control required" aria-required="true">
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
                                    <input id="delivery_address" name="delivery_address" type="text" class="form-control required" aria-required="true" value="{{ old('delivery_address', $order->delivery_address) }}">
                                </div>
                                @foreach($errors->get('delivery_address') as $err)
                                    <label class="error" for="delivery_address">{{ $err }}</label>
                                @endforeach
                            </div>

                            <div class="form-group {{ count($errors->get('delivery_note')) > 0 ? 'has-error' : '' }}">
                                <label>Ghi chú giao hàng</label>
                                <textarea id="delivery_note" name="delivery_note" placeholder="" class="form-control" rows="5" cols="50">{{ old('delivery_note', $order->delivery_note) }}</textarea>
                                <span class="help-block m-b-none">Ghi chú về việc giao hàng.</span>
                                @foreach($errors->get('delivery_note') as $err)
                                    <label class="error" for="delivery_note">{{ $err }}</label>
                                @endforeach
                            </div>
                        @else
                            <div class="form-group">
                                <strong>Chỉ có thể thay đổi thông tin địa chỉ giao hàng khi đơn hàng ở trạng thái đợi duyệt hay đã duyệt</strong>
                            </div>
                        @endif

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div>
                                <input class="btn btn-primary" type="submit" value="Sửa">
                                <a href="{{ URL::action('OrdersController@index') }}" class="btn btn-white"> Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="ibox">
                <div class="ibox-content">
                            <span class="text-muted small pull-right">{{ $products->count() }} sản phẩm</span>
                            <h2>Danh sách sản phẩm được đặt</h2>
                            <form method="post" action="{{ URL::action('OrdersController@updateOrderProducts', ['id' => $order->id]) }}">
                                {{ csrf_field() }}
                                <div class="input-group date">
                                    <select name="attach_product_id[]" id="product_id" class="form-control" multiple="multiple"></select>
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-danger btn-sm">Lưu</button>
                                    </span>
                                </div>
                                <table class="footable table table-stripped toggle-arrow-tiny">
                                    <thead>
                                    <tr>
                                        <th data-sort-ignore="true">
                                            <div class="i-checks">
                                                <label>
                                                    <input type="checkbox" id="select_all">
                                                </label>
                                            </div>
                                        </th>
                                        <th data-sort-ignore="true">Tên</th>
                                        <th data-sort-ignore="true">Hiển thị</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i = 0; $i < $products->count(); $i++)
                                        <tr>

                                            <td>
                                                <div class="i-checks">
                                                    <label>
                                                        <input type="checkbox" name="detach_product_id[]" value="{{ $products[$i]->id }}">
                                                    </label>
                                                </div>
                                            </td>
                                            <td style="width:1%; white-space:nowrap">
                                                <img src="{{ $products[$i]->image }}" style="width:80px; height: 120px; background: grey" />
                                            </td>
                                            <td>
                                                <div><strong>{{ $products[$i]->name }}</strong></div>
                                            </td>
                                            <td>
                                                {{ $products[$i]->description }}
                                                <div>
                                                    <ul class="list-inline" style="padding-top: 5px; margin-bottom: 0px;">
                                                        <li style="width:100%; position: relative">
                                                            <div class="form-inline">
                                                                <?php $index = 0 ?>
                                                                <input type="hidden" name="update_product[{{ $i }}][id]" value="{{ $products[$i]->id }}">
                                                                <input style="width:60px" type="number" step="0.01" name="update_product[{{ $i }}][quantity]" class="form-control input-xs" value="{{ $products[$i]->pivot->quantity }}" />
                                                                <input style="width:100px" type="number" step="0.01" name=update_product[{{ $i }}][price]" class="form-control input-xs" value="{{ $products[$i]->pivot->price }}" />
                                                                <button data-product_id="{{ $products[$i]->id }}" class="control-detail update btn btn-xs btn-outline btn-primary">
                                                                    <i class="fa fa-refresh"></i> Cập nhật
                                                                </button>
                                                                <?php $index++ ?>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4">
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </form>
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

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $('#select_all').on('ifToggled', function(event){
            $('input[name="detach_product_id[]"').iCheck('toggle');
        });
        $("#product_id").select2({
            placeholder: "Thêm sản phẩm vào đơn đặt hàng",
            ajax: {
                url: '{{ URL::action('ProductsController@queryProducts') }}',
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
                        data.url = data.url
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
                console.log(item.image);
                markup = '<div><img src="'+ item.image + '" style="width:40px; height: 60px; background: grey" /><span> ' + item.text + '</span></div>';
                return markup;
            },
            templateSelection: function (item) {
                return '<option data-url="' + item.url + '" style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
            }
        });
    </script>
@endsection
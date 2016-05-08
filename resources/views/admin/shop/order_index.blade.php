<?php
app('navigator')
        ->activate('orders', 'index')
        ->set_page_heading('Danh sách đơn đặt hàng')
        ->set_breadcrumb('admin', 'orders')
        ->set_page_title('Danh sách đơn đặt hàng');
?>

@extends('partials.admin._layout')

@section('content')
<div class="ibox-content m-b-sm border-bottom">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="order_id">Mã đơn đặt hàng</label>
                <input type="text" id="order_id" name="order_id" placeholder="" class="form-control" value="{{ $filter_order_id }}">
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="customer_name">Tên khách</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ $filter_customer_name }}" placeholder="" class="form-control">
            </div>
        </div>

        <div class="col-md-4">
            <label class="control-label" for="status_id">Trạng thái</label>
            <select id="status_id" name="status_id" class="status_id form-control">
                <option value="NULL">Tất cả trạng thái</option>
                @foreach($order_status as $status)
                    @if($filter_status_id == $status['id'])
                        <option value="{{ $status['id'] }}" selected="selected">{{ $status['label'] }}</option>
                    @else
                        <option value="{{ $status['id'] }}">{{ $status['label'] }}</option>
                    @endif
                @endforeach
            </select>
        </div>


    </div>
    <div class="row">
        <div class="col-sm-8">
            <div class="form-group" id="data_5">
                <label class="control-label" for="datepicker">Ngày đặt</label>
                <div class="input-daterange input-group" id="datepicker">
                    <input id="datetimepicker_created_at_start" type="text" class="input form-control" data-dvalue="{{ $filter_created_at_start }}">
                    <span class="input-group-addon">đến</span>
                    <input id="datetimepicker_created_at_end" type="text" class="input form-control" data-dvalue="{{ $filter_created_at_end }}">
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="action">&nbsp;</label>
                <div style="clear:both"></div>
                <div class="btn-group pull-right" id="action">
                    <button type="button" class="cancel btn btn-white">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">

                <table class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="{{ $orders->perPage() }}">
                    <thead>
                    <tr>

                        <th data-sort-ignore="true">Mã</th>
                        <th data-sort-ignore="true" data-hide="phone">Tên khách</th>
                        <th data-sort-ignore="true" data-hide="phone">Thành tiền</th>
                        <th data-sort-ignore="true" data-hide="phone">Ngày đặt</th>
                        <th data-sort-ignore="true" data-hide="phone,tablet">Ngày thay đổi</th>
                        <th data-sort-ignore="true" data-hide="phone">Trạng thái</th>
                        <th data-sort-ignore="true" class="text-right">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            {{ $order->id }}
                        </td>
                        <td>
                            <div>{{ $order->customer_name }}</div>
                            @if($order->user_id != null)
                                <div><a href="{{URL::action('UsersController@show', ['id' => $order->user_id])}}">{{ $order->user->name }}</a></div>
                            @else
                                <div>&nbsp</div>
                            @endif
                        </td>
                        <td>
                            {{ $order->amount }}
                        </td>
                        <td>
                            {{ $order->created_at }}
                        </td>
                        <td>
                            {{ $order->updated_at }}
                        </td>
                        <td>
                            @if($order->status_id == 1)
                                <span class="label label-danger">{{ $order->status->label }}</span>
                            @elseif($order->status_id == 2)
                                <span class="label label-success">{{ $order->status->label }}</span>
                            @elseif($order->status_id == 3)
                                <span class="label label-info">{{ $order->status->label }}</span>
                            @elseif($order->status_id == 4)
                                <span class="label label-default">{{ $order->status->label }}</span>
                            @elseif($order->status_id == 5)
                                <span class="label label-primary">{{ $order->status->label }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                @if($order->status_id == 1)
                                    <button data-order_id="{{ $order->id }}" class="order-approve btn-white btn btn-xs">Duyệt</button>
                                @elseif($order->status_id == 2)
                                    <button data-order_id="{{ $order->id }}" class="order-deliver btn-white btn btn-xs">Giao hàng</button>
                                @elseif($order->status_id == 3)
                                    <button data-order_id="{{ $order->id }}" class="order-complete btn-white btn btn-xs">Hoàn tất</button>
                                @endif
                                @if($order->status_id != 5 && $order->status_id != 4)
                                    <button data-order_id="{{ $order->id }}" class="order-cancel btn-white btn btn-xs">Hủy</button>
                                    <button class="btn-white btn btn-xs">Sửa</button>
                                @endif
                                <button class="btn-white btn btn-xs">Chi tiết</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="pull-right">{!! $orders->links() !!}</div>
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
        $('.footable').footable();

        created_at_start = $('#datetimepicker_created_at_start').data('dvalue');
        $('#datetimepicker_created_at_start').datetimepicker({
            format: 'LLLL',
            defaultDate: created_at_start != '' ? moment.tz(created_at_start, "utc").tz(moment.tz.guess()).format('YYYY-MM-DD HH:mm:ss') : null
        }).on("dp.change", function (e) {
            $('#datetimepicker_created_at_end').data("DateTimePicker").minDate(e.date);
        });

        created_at_end = $('#datetimepicker_created_at_end').data('dvalue');
        $('#datetimepicker_created_at_end').datetimepicker({
            format: 'LLLL',
            defaultDate: created_at_end != '' ? moment.tz(created_at_end, "utc").tz(moment.tz.guess()).format('YYYY-MM-DD HH:mm:ss') : null,
            useCurrent: false //Important! See issue #1075
        }).on("dp.change", function (e) {
            $('#datetimepicker_created_at_start').data("DateTimePicker").maxDate(e.date);
        });

        var filter = function(created_at_start, created_at_end, order_id, customer_name, status_id) {
            token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ URL::action('OrdersController@postConfigs') }}',
                method: 'post',
                data: {
                    'configs' : [
                        { name: "filter.created_at_start", value: created_at_start },
                        { name: "filter.created_at_end", value: created_at_end },
                        { name: "filter.order_id", value: order_id },
                        { name: "filter.customer_name", value: customer_name },
                        { name: "filter.status_id", value: status_id }
                    ]
                },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function() {
                location.reload();
            });
        };

        $('.order-approve').click(function() {
            token = $('meta[name="csrf-token"]').attr('content');
            var order_id = $(this).data('order_id');
            $.ajax({
                url: '{{ URL::action('OrdersController@approve') }}',
                method: 'post',
                data: {
                    'order_id' : order_id
                },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    },
                    404: function(jqXHR, textStatus, errorThrown){
                        toastr.error('Không tìm thấy sản phẩm này.<br>Vui lòng thử lại.');
                    }
                }
            }).done(function() {
                location.reload();
            });
        });

        $('.order-deliver').click(function() {
            token = $('meta[name="csrf-token"]').attr('content');
            var order_id = $(this).data('order_id');
            $.ajax({
                url: '{{ URL::action('OrdersController@deliver') }}',
                method: 'post',
                data: {
                    'order_id' : order_id
                },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    },
                    404: function(jqXHR, textStatus, errorThrown){
                        toastr.error('Không tìm thấy sản phẩm này.<br>Vui lòng thử lại.');
                    }
                }
            }).done(function() {
                location.reload();
            });
        });

        $('.order-complete').click(function() {
            token = $('meta[name="csrf-token"]').attr('content');
            var order_id = $(this).data('order_id');
            $.ajax({
                url: '{{ URL::action('OrdersController@complete') }}',
                method: 'post',
                data: {
                    'order_id' : order_id
                },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    },
                    404: function(jqXHR, textStatus, errorThrown){
                        toastr.error('Không tìm thấy sản phẩm này.<br>Vui lòng thử lại.');
                    }
                }
            }).done(function() {
                location.reload();
            });
        });

        $('.order-cancel').click(function() {
            token = $('meta[name="csrf-token"]').attr('content');
            var order_id = $(this).data('order_id');
            $.ajax({
                url: '{{ URL::action('OrdersController@cancel') }}',
                method: 'post',
                data: {
                    'order_id' : order_id
                },
                headers: {
                    'X-CSRF-TOKEN': token
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    },
                    404: function(jqXHR, textStatus, errorThrown){
                        toastr.error('Không tìm thấy sản phẩm này.<br>Vui lòng thử lại.');
                    }
                }
            }).done(function() {
                location.reload();
            });
        });

        $('button.cancel').on('click', function() {
            filter ('NULL', 'NULL', 'NULL', 'NULL', 'NULL')
        });

        $('button[type="submit"]').on('click', function(){
            // get datetime from datetimepicker plugin
            time = $('#datetimepicker_created_at_start').data("DateTimePicker").date();
            if(time == null)
                created_at_start = 'NULL';
            else {
                // corecting timezone (wrong because of datetimepicker bug)
                time = moment.tz(time.format('YYYY-MM-DD HH:mm:ss'), moment.tz.guess()).format();
                // converting timezone to UTC and send back to server
                created_at_start = moment(time).utc().format('YYYY-MM-DD HH:mm:ss');
            }
            // get datetime from datetimepicker plugin
            time = $('#datetimepicker_created_at_end').data("DateTimePicker").date();
            if(time == null)
                created_at_end = 'NULL';
            else {
                // corecting timezone (wrong because of datetimepicker bug)
                time = moment.tz(time.format('YYYY-MM-DD HH:mm:ss'), moment.tz.guess()).format();
                // converting timezone to UTC and send back to server
                created_at_end = moment(time).utc().format('YYYY-MM-DD HH:mm:ss');
            }
            order_id = $('#order_id').val();
            customer_name = $('#customer_name').val();
            status_id = $('#status_id').val();
            filter(created_at_start, created_at_end, order_id, customer_name, status_id);
        });

    </script>
@endsection

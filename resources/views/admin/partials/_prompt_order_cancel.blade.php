@section('order-cancel_inputs')
    <input name="order_id" type="hidden">
@endsection

@include('admin.partials._prompt',[
    'id' => 'order-cancel',
    'method' => 'post',
    'action' => URL::action('OrdersController@cancel'),
    'title' => 'Hủy bỏ đơn đặt hàng',
    'message' => 'Sau khi chuyển sang trạng thái hủy bỏ, hệ thống sẽ tự động gửi một email thông báo đến người dùng.'
])

@section('footer-script')
    @parent
    <script>
        $('#modal-order-cancel-prompt').on('show.bs.modal', function(e) {
            order_id = $(e.relatedTarget).data('order_id');
            $(e.currentTarget).find('input[name="order_id"]').val(order_id);
        });
    </script>
@endsection
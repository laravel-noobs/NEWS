@section('order-complete_inputs')
    <input name="order_id" type="hidden">
@endsection

@include('admin.partials._prompt',[
    'id' => 'order-complete',
    'method' => 'post',
    'action' => URL::action('OrdersController@complete'),
    'title' => 'Hoàn tất đơn đặt hàng',
    'message' => 'Sau khi chuyển sang trạng thái hoàn tất, hệ thống sẽ tự động gửi một email thông báo đến người dùng.'
])

@section('footer-script')
    @parent
    <script>
        $('#modal-order-complete-prompt').on('show.bs.modal', function(e) {
            order_id = $(e.relatedTarget).data('order_id');
            $(e.currentTarget).find('input[name="order_id"]').val(order_id);
        });
    </script>
@endsection
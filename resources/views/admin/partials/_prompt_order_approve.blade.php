@section('order-approve_inputs')
    <input name="order_id" type="hidden">
@endsection

@include('admin.partials._prompt',[
    'id' => 'order-approve',
    'method' => 'post',
    'action' => URL::action('OrdersController@approve'),
    'title' => 'Duyệt đơn đặt hàng',
    'message' => 'Sau khi duyệt đơn đặt hàng, hệ thống sẽ tự động gửi một email thông báo đến người dùng.'
])

@section('footer-script')
    @parent
    <script>
        $('#modal-order-approve-prompt').on('show.bs.modal', function(e) {
            order_id = $(e.relatedTarget).data('order_id');
            $(e.currentTarget).find('input[name="order_id"]').val(order_id);
        });
    </script>
@endsection
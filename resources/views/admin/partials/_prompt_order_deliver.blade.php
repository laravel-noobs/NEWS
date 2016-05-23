@section('order-deliver_inputs')
    <input name="order_id" type="hidden">
@endsection

@include('admin.partials._prompt',[
    'id' => 'order-deliver',
    'method' => 'post',
    'action' => URL::action('OrdersController@deliver'),
    'title' => 'Tiến hành giao hàng',
    'message' => 'Sau khi chuyển sang trạng thái giao hàng, hệ thống sẽ tự động gửi một email thông báo đến người dùng.'
])

@section('footer-script')
    @parent
    <script>
        $('#modal-order-deliver-prompt').on('show.bs.modal', function(e) {
            order_id = $(e.relatedTarget).data('order_id');
            $(e.currentTarget).find('input[name="order_id"]').val(order_id);
        });
    </script>
@endsection
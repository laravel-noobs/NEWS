<?php
app('navigator')
        ->activate('users', 'index')
        ->set_page_heading('Danh sách người dùng')
        ->set_breadcrumb('admin', 'users')
        ->set_page_title('Danh sách tất cả người dùng');
?>

@extends('partials.admin._layout')

@section('content')
 <div class="row">
     <div class="col-sm-8">
         <div class="ibox">
             <div class="ibox-content">
                 <span class="text-muted small pull-right">123</span>
                 <h2>Danh sách</h2>
                 <input type="text" class="form-control input-sm m-b-xs" id="filter"
                        placeholder="Tìm kiếm">
                 <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15" data-filter=#filter>
                     <thead>
                     <tr>
                         <th>Mã</th>
                         <th>Tên đăng nhập</th>
                         <th data-hide="phone, tablet">Họ tên</th>
                         <th data-hide="phone">Email</th>
                         <th data-hide="phone">Khóa</th>
                         <th data-hide="phone">Xác nhận</th>
                         <th data-sort-ignore="true"><span class="pull-right">Hành động</span></th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach($users as $user)
                         <tr>
                             <td>{{ $user->id }}</td>
                             <td>{{ $user->name }}</td>
                             <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                             <td>{{ $user->email }}</td>
                             <td>
                                 @if($user->banned)
                                    <i class="fa fa-lock"></i>
                                 @endif
                             </td>
                             <td>
                                 @if(!$user->verified)
                                     <i class="fa fa-eye-slash"></i>
                                 @endif
                             </td>
                             <td>
                                 <div class="btn-group pull-right">
                                     <a href="{{ action('UsersController@edit',['id'=>$user->id]) }}"  class="btn-white btn btn-xs">Sửa</a>
                                     <a href="#" target="_blank" class="btn-white btn btn-xs">Xem</a>
                                     <a data-toggle="modal" href="#modal-user-ban-prompt" data-user_email="{{ $user->email }}" data-user_name="{{ $user->name }}" data-user_id="{{ $user->id }}" class="btn-white btn btn-xs">Khóa</a>
                                 </div>
                             </td>
                         </tr>
                     @endforeach
                     </tbody>
                     <tfoot>
                     <tr>
                         <td colspan="6">
                             <ul class="pagination pull-right"></ul>
                         </td>
                     </tr>
                     </tfoot>
                 </table>
             </div>
         </div>
    </div>
</div>
@section('user-ban_inputs')
    <input name="user_id" type="hidden"/>
    <div class="form-group">
        <label class="">Lý do</label>
        <input type="text" name="reason" placeholder="" value="" class="form-control">
    </div>
    <div class="form-group">
        <label class="">Ngày hết hạn</label>
        <div class="input-group m-b date">
            <div class="input-group-btn">
                <button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">Tùy chọn <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <li><a class="date-option" data-value="3"  data-unit="days">3 ngày</a></li>
                    <li><a class="date-option" data-value="7" data-unit="days">7 ngày</a></li>
                    <li><a class="date-option" data-value="1" data-unit="months">1 tháng</a></li>
                    <li><a class="date-option" data-value="3" data-unit="months">3 tháng</a></li>
                    <li><a class="date-option" data-value="6" data-unit="months">6 tháng</a></li>
                    <li><a class="date-option" data-value="9" data-unit="months">9 tháng</a></li>
                    <li><a class="date-option" data-value="1" data-unit="years">1 năm</a></li>
                </ul>
            </div>
            <input type="hidden" name="expired_at" />
            <input id="datetimepicker_expired_at" type='text' class="form-control" />
        </div>
    </div>
    <div class="form-group" style="margin-bottom: 0px;">
        <label>To:</label> <span class="user_email"></span>
        <textarea class="form-control" style="width: 100%" rows="10" name="message"></textarea>
    </div>
@endsection
@include('admin.partials._prompt',[
    'id' => 'user-ban',
    'method' => 'post',
    'action' => URL::action('UsersController@ban'),
    'title' => 'Xác nhận',
    'message' => 'Bạn có chắc chắn muốn khóa tài khoản "<span class="user_name">này</span>" hay không?',
])
@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });
        $(function () {
            $('#datetimepicker_expired_at').datetimepicker({
                format: 'HH:mm - dddd DD/MM/YYYY',
                minDate: moment().add(3, 'days')
            });
        });
        $('#modal-user-ban-prompt').on('show.bs.modal', function(e) {
            user_id = $(e.relatedTarget).data('user_id');
            user_name = $(e.relatedTarget).data('user_name');
            user_email = $(e.relatedTarget).data('user_email');
            $(e.currentTarget).find('input[name="user_id"]').val(user_id);
            $(e.currentTarget).find('span.user_name').text(user_name);
            $(e.currentTarget).find('span.user_email').text(user_email);
        });

        $('#modal-user-ban-prompt .date-option').on('click', function(){
            $('#datetimepicker_expired_at').data("DateTimePicker").date(moment().add($(this).data('value'), $(this).data('unit')))
        });

        $('#modal-user-ban-prompt button[type="submit"]').click(function(e)
        {
            $('input[name="expired_at"]').val($('#datetimepicker_expired_at').data("DateTimePicker").date().utc().format('YYYY-MM-DD hh:mm:ss'));
        });
    </script>
@endsection
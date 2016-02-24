<?php
app('navigator')
        ->activate('users', 'index')
        ->set_page_heading('Danh sách người dùng')
        ->set_breadcrumb('admin', 'users')
        ->set_page_title('Danh sách tất cả người dùng');
?>

@extends('partials.admin._layout')

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

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group search-box">
                                <input placeholder="Tìm người dùng" id="search-input" type="text" class="form-control input-sm" value="{{ $filter_search_term }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn-white btn btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="role_id" name="role_id" class="role form-control">
                                <option value="*">Tất cả vai trò</option>
                                @foreach($roles as $role)
                                    @if($filter_role == $role['id'])
                                        <option value="{{ $role['id'] }}" selected="selected">{{ $role['name'] }}</option>
                                    @else
                                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'verified' ? 'checked' : '' }} value="verified"> Đã xác thực
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'pending' ? 'checked' : '' }} value="pending"> Chưa xác thực
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'banned' ? 'checked' : '' }} value="banned"> Bị khóa
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
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Danh sách người dùng</h5>
                    <span class="text-muted small pull-right">{{ $users->total() }} người dùng</span>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="{{ $users->perPage() }}">
                     <thead>
                     <tr>
                         <th data-sort-ignore="true">Tên đăng nhập</th>
                         <th data-sort-ignore="true" data-hide="phone, tablet">Họ tên</th>
                         <th data-sort-ignore="true" data-hide="phone">Email</th>
                         <th data-sort-ignore="true" data-hide="phone">Vai trò</th>
                         <th data-sort-ignore="true" data-hide="phone">Bài viết</th>
                         <th data-sort-ignore="true" data-hide="phone">Phản hồi</th>
                         @if($filter_status_type != 'banned')
                            <th data-sort-ignore="true" data-hide="phone">Khóa</th>
                         @else
                             <th data-sort-ignore="true" data-hide="phone">Xác thực</th>
                         @endif

                         <th data-sort-ignore="true" data-sort-ignore="true"><span class="pull-right">Hành động</span></th>
                     </tr>
                     </thead>
                     <tbody>
                     @foreach($users as $user)
                         <tr>
                             <td>{{ $user->name }}</td>
                             <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                             <td>{{ $user->email }}</td>
                             <td>{{ $user->role ? $user->role->name : '' }}</td>
                             <td>{{ $user->postsCount }}</td>
                             <td>{{ $user->feedbacksCount }}</td>
                             @if($filter_status_type != 'banned')
                                 <td>
                                     @if($user->banned)
                                        <i class="fa fa-lock"></i>
                                     @endif
                                 </td>
                             @else
                                 <td>
                                     @if(!$user->verified)
                                         <i class="fa fa-eye-slash"></i>
                                     @endif
                                 </td>
                             @endif
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
                         <td colspan="8">
                             <div class="pull-right">{!! $users->links() !!}</div>
                         </td>
                     </tr>
                     </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

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
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-gree',
            radioClass: 'iradio_square-green'
        });

        $(".role").select2({
            placeholder: "Lọc theo vai trò",
            minimumResultsForSearch: Infinity,
            tags: true
        });

        $(function () {
            $('#datetimepicker_expired_at').datetimepicker({
                format: 'HH:mm - dddd DD/MM/YYYY',
                minDate: moment().add(3, 'days')
            });
        });

        $('input[name="status_type"]').on('ifChecked', function(event){
            $.ajax({
                url: location.pathname + '/config',
                method: 'post',
                data: { name: "filter.status_type", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('select[name="role_id"]').on("select2:select", function (e) {
            cat_id = $(e.currentTarget).val();
            $.ajax({
                url: location.pathname + '/config',
                method: 'post',
                data: { name: "filter.role", value: cat_id === '*' ? 'NULL' : cat_id },
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
                url: location.pathname + '/config',
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
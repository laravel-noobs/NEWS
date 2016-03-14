<?php
app('navigator')
        ->activate('privileges')
        ->set_page_heading('Cấp quyền')
        ->set_breadcrumb('admin', 'privileges', 'privilege_grant')
        ->set_page_title('Cấp quyền');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="form-inline">
                    <select id="role_id" name="role_id" class="role form-input">
                        @foreach($roles as $role)
                            @if($filter_role == $role['id'])
                                <option value="{{ $role['id'] }}" selected="selected">{{ $role['label'] }}</option>
                            @else
                                <option value="{{ $role['id'] }}">{{ $role['label'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="text-muted small pull-right">{{ $permissions->count() }} quyền</span>
                    </div>
                </div>
                <div class="ibox-content">
                    @if($selected_role->name == 'administrator')
                        <h5>Quyền hạn của quản trị viên không thể thay đổi.</h5>
                    @else
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="{{ $permissions->count() }}">
                            <thead>
                            <tr>
                                <th data-sort-ignore="true"></th>
                                <th data-sort-ignore="true">Định danh</th>
                                <th data-sort-ignore="true" data-hide="phone, tablet">Tên</th>
                                <th data-sort-ignore="true" data-hide="phone">Vai trò</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td><div class="i-checks">
                                            <label>
                                                <input class="permission" type="checkbox" {{ $permission->isGrantedTo($selected_role) ? 'checked' : '' }} value="{{ $permission->id }}">
                                            </label>
                                        </div></td>
                                    <td> {{ $permission->name }}</td>
                                    <td> {{ $permission->label }}</td>
                                    <td>
                                        <ul class="list-inline">
                                            @foreach($permission->roles as $role)
                                                <li><span class="badge {{ $role->name }}">{{ $role->label }}</span></li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4">

                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        $('.footable').footable();

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $(".role").select2({
            minimumResultsForSearch: -1,
            placeholder: "Lọc theo chuyên mục"
        });

        $('input.permission').on('ifToggled', function(e){
            granted = e.target.checked;
            permission_id = e.target.value;
            role_id = $('#role_id').val();

            $.ajax({
                url: '{{ URL::action('PrivilegesController@grantToRole') }}',
                method: 'post',
                data: { role_id: role_id, permission_id: permission_id, granted: granted ? '1' : '0'},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data) {
                toastr[data.result ? 'success' : 'error'](data.msg);
            });
        });

        $('select[name="role_id"]').on("select2:select", function (e) {
            role_id = $(e.currentTarget).val();
            $.ajax({
                url: '{{ URL::action('PrivilegesController@postConfig') }}',
                method: 'post',
                data: { name: "filter.role", value: role_id === '*' ? 'NULL' : role_id },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>

@endsection
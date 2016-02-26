<?php
app('navigator')
        ->activate('privileges')
        ->set_page_heading('Quyền hạn của bạn')
        ->set_breadcrumb('admin', 'privileges')
        ->set_page_title('Quyền hạn của bạn');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Danh sách quyền hạn của bạn</h5>
                    <span class="text-muted small pull-right">{{ $role_permissions->count() }} quyền</span>
                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="{{ $role_permissions->count() }}">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true">Định danh</th>
                            <th data-sort-ignore="true" data-hide="phone, tablet">Tên</th>
                            <th data-sort-ignore="true" data-hide="phone">Vai trò</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($role_permissions as $permission)
                            <tr>
                                <td> {{ $permission->permission->name }}</td>
                                <td> {{ $permission->permission->label }}</td>
                                <td> {{ $permission->role->label}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="3">

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
        $(document).ready(function(){
            $('.footable').footable();
        });
    </script>
@endsection
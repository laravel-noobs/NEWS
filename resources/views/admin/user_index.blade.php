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
                     <th data-hide="all">Tên đăng nhập</th>
                     <th data-hide="phone, tablet">Họ tên</th>
                     <th data-hide="phone">Email</th>
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
                             <div class="btn-group pull-right">
                                 <a href="{{ action('UsersController@edit',['id'=>$user->id]) }}"  class="btn-white btn btn-xs">Sửa</a>
                                 <a href="#" target="_blank" class="btn-white btn btn-xs">Xem</a>
                                 <a href="{{ action('UsersController@delete', ['id' => $user->id]) }}" class="btn-white btn btn-xs">Xóa</a>
                             </div>
                         </td>
                     </tr>
                 @endforeach
                 </tbody>
                 <tfoot>
                 <tr>
                     <td colspan="4">
                         <ul class="pagination pull-right"></ul>
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
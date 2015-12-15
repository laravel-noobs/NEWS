@extends('unify.partials._layout')

@section('content')
    <div class="container-fluid margin-top-20 margin-bottom-20">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 block-1">
                <form class="reg-page" role="form" method="POST" action="{{ URL::action('Auth\AuthController@postRegister') }}">
                    <div class="reg-header">
                        <h2>Đăng ký tài khoản mới</h2>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="input-daterange input-group margin-bottom-20">
                        <input type="last_name" placeholder="Họ" class="form-control" name="last_name" value="{{ old('last_name') }}">
                        <span class="input-group-addon " style="padding:5px"></span>
                        <input type="first_name" placeholder="Tên" class="form-control" name="first_name" value="{{ old('first_name') }}">

                    </div>

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="name" placeholder="Tên đăng nhập" class="form-control" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" placeholder="Mật khẩu" class="form-control" name="password">
                    </div>

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" placeholder="Xác nhận mật khẩu" class="form-control" name="password_confirmation">
                    </div>

                    <div class="row">
                        <div class="col-md-8 checkbox">
                            <label><input type="checkbox" name="tos">Đồng ý với <a href="#tos">thỏa thuận</a>.</label>
                        </div>
                        <div class="col-md-4">
                            <button class="btn-u btn-u-default pull-right" type="submit">Đăng ký</button>
                        </div>
                    </div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <hr>
                    <p>Vui lòng <a class="color-red" href="{{ action('Auth\AuthController@getLogin') }}">đăng nhập</a> nếu bạn đã có tài khoản.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
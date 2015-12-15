@extends('unify.partials._layout')

@section('content')
    <div class="container-fluid margin-top-20 margin-bottom-20">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 block-1">
                <form class="reg-page" role="form" method="POST" action="{{ URL::action('Auth\AuthController@postLogin') }}">
                    <div class="reg-header">
                        <h2>Đăng nhập tài khoản</h2>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>
                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" placeholder="Mật khẩu" class="form-control" name="password">
                    </div>

                    <div class="row">
                        <div class="col-md-6 checkbox" name="remember">
                            <label><input type="checkbox"> Nhớ tài khoản</label>
                        </div>
                        <div class="col-md-6">
                            <button class="btn-u btn-u-default pull-right" type="submit">Đăng nhập</button>
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

                    <h4>Quên mật khẩu ?</h4>
                    <p>đừng lo lắm, <a class="color-red" href="{{ url('/password/email') }}">nhấp vào đây</a> để đặt lại mật khẩu.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
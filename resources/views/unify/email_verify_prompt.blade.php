@extends('unify.partials._layout')

@section('content')
    <div class="container-fluid margin-top-20 margin-bottom-20">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 block-1">
                <form class="reg-page" role="form" method="POST" action="{{URL::action('UsersController@postVerifyEmail')}}">
                    <div class="reg-header">
                        <h2>Xác thực email</h2>
                    </div>

                    {{ csrf_field() }}

                    <div class="input-group margin-bottom-20">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="text" placeholder="Mã xác thực" class="form-control" name="verify_token">
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

                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <button class="btn-u btn-u-default pull-right" type="submit">Xác thực</button>
                        </div>
                    </div>


                    <hr>

                    <h4>Quên mật khẩu ?</h4>
                    <p>đừng lo lắm, <a class="color-red" href="{{ url('/password/email') }}">nhấp vào đây</a> để đặt lại mật khẩu.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
<?php
app('navigator')
        ->activate('users', 'edit')
        ->set_page_heading('Sửa thông tin người dùng')
        ->set_breadcrumb('admin', 'users', 'user_edit')
        ->set_page_title('Sửa thông tin người dùng ' . $user->email);
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Sửa thông tin người dùng</h3>
                    <form method="POST" action="{{ URL::action('UsersController@update', ['id' => $user->id ]) }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', $user->name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của người dùng được tạo sẽ dùng để đăng nhập.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('password')) > 0 ? 'has-error' : '' }}">
                            <label>Mật khẩu</label>
                            <input type="password" id="password" name="password" placeholder="" value="" class="form-control">
                            <span class="help-block m-b-none">Mật khẩu của người dùng được tạo để đăng nhập và bảo mật cho người dùng.</span>
                            @foreach($errors->get('password') as $err)
                                <label class="error" for="password">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('email')) > 0 ? 'has-error' : '' }}">
                            <label>E-mail</label>
                            <input type="text" id="email" name="email" placeholder="" value="{{ old('email', $user->email) }}" class="form-control">
                            <span class="help-block m-b-none">E-mail của người dùng được tạo để đăng nhập hoặc liên lạc với người dùng.</span>
                            @foreach($errors->get('email') as $err)
                                <label class="error" for="email">{{ $err }}</label>
                            @endforeach
                        </div>


                        <div class="form-group {{ count($errors->get('first_name')) > 0 ? 'has-error' : '' }}">
                            <label>Tên</label>
                            <input type="text" id="first_name" name="first_name" placeholder="" value="{{ old('first_name', $user->first_name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của người dùng.</span>
                            @foreach($errors->get('first_name') as $err)
                                <label class="error" for="first_name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('last_name')) > 0 ? 'has-error' : '' }}">
                            <label>Họ</label>
                            <input type="text" id="last_name" name="last_name" placeholder="" value="{{ old('last_name', $user->last_name) }}" class="form-control">
                            <span class="help-block m-b-none">Họ của người dùng.</span>
                            @foreach($errors->get('last_name') as $err)
                                <label class="error" for="last_name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div>
                                <input class="btn btn-primary" type="submit" value="Sửa">
                                <a href="#" class="btn btn-white"> Hủy</a>
                            </div>
                        </div>
                    </form>
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
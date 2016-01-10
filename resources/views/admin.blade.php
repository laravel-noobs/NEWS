<?php
    app('navigator')
            ->activate('admin')
            ->set_page_title('Bảng điều khiển');
?>

@extends('partials.admin._layout')
@section('content')
    <h1>Hello World!</h1>
@endsection
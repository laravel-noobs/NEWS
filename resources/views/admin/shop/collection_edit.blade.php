<?php
app('navigator')
        ->activate('collections')
        ->set_page_heading('Sửa thông tin nhóm sản phẩm')
        ->set_breadcrumb('collections', 'collection_edit')
        ->set_page_title('Sửa thông tin nhóm sản phẩm');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        @can('storeProductCategory')
        <div class="col-sm-4">
            <div class="ibox ">
                <div class="ibox-content">
                    <h3>Thêm mới nhóm sản phẩm</h3>
                    <form method="POST" action="{{ URL::action('CollectionsController@update', ['id' => $collection->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', $collection->name) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhóm sản phẩm để quản lý. Không trùng nhau.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('name')) > 0 ? 'has-error' : '' }}">
                            <label class="">Tên hiển thị</label>
                            <input type="text" id="name" name="name" placeholder="" value="{{ old('name', $collection->label) }}" class="form-control">
                            <span class="help-block m-b-none">Tên của nhóm sản phẩm dùng để hiển thị.</span>
                            @foreach($errors->get('name') as $err)
                                <label class="error" for="name">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('slug')) > 0 ? 'has-error' : '' }}">
                            <label>Slug</label>
                            <input type="text" id="slug" name="slug" placeholder="" value="{{ old('slug', $collection->slug) }}" class="form-control">
                            <span class="help-block m-b-none">Chuỗi ký tự dùng để tạo đường dẫn thân thiện, thường chỉ bao gồm các ký tự từ aphabet không dấu, chữ số và dấu gạch ngang.</span>
                            @foreach($errors->get('slug') as $err)
                                <label class="error" for="slug">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="form-group {{ count($errors->get('description')) > 0 ? 'has-error' : '' }}">
                            <label>Mô tả</label>
                            <textarea id="description" name="description" placeholder="" class="form-control" rows="5" cols="50">{{ old('description', $collection->description) }}</textarea>
                            <span class="help-block m-b-none">Mô tả nhóm sản phẩm tùy thuộc vào themes mà có thể được hiển thị hay không.</span>
                            @foreach($errors->get('description') as $err)
                                <label class="error" for="description">{{ $err }}</label>
                            @endforeach
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div>
                                <input class="btn btn-primary" type="submit" value="Thêm mới">
                                <a href="{{ URL::previous() }}" class="btn btn-white"> Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <div class="col-sm-8">
        @else
            <div class="col-sm-12">
        @endcan
                <div class="ibox">
                        <div class="ibox-content">
                            <span class="text-muted small pull-right">{{ $products->total() }} sản phẩm</span>
                            <h2>Danh sách sản phẩm</h2>
                            <form method="post" action="{{ URL::action('CollectionsController@syncProducts', ['collection' => $collection->id]) }}">
                                {{ csrf_field() }}
                                @can('syncProductsCollection')
                                <div class="input-group date">
                                    <select name="attach_product_id[]" id="product_id" class="form-control" multiple="multiple"></select>
                                    <span class="input-group-btn">
                                        <button type="submit"class="btn btn-danger btn-sm">Lưu</button>
                                    </span>
                                </div>
                                @endcan
                                <table class="footable table table-stripped toggle-arrow-tiny" data-page-navigation=".footable-pagination" data-page-size="{{ $products->perPage() }}">
                                <thead>
                                <tr>
                                    @can('syncProductsCollection')
                                    <th data-sort-ignore="true">
                                        <div class="i-checks">
                                            <label>
                                                <input type="checkbox" id="select_all">
                                            </label>
                                        </div>
                                    </th>
                                    @endcan
                                    <th data-sort-ignore="true">Tên</th>
                                    <th data-sort-ignore="true">Hiển thị</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        @can('syncProductsCollection')
                                        <td>
                                            <div class="i-checks">
                                                <label>
                                                    <input type="checkbox" name="detach_product_id[]" value="{{ $product->id }}">
                                                </label>
                                            </div>
                                        </td>
                                        @endcan
                                        <td style="width:1%; white-space:nowrap">
                                            <img src="{{ $product->image }}" style="width:80px; height: 120px; background: grey" />
                                        </td>
                                        <td>
                                            <div><strong>{{ $product->name }}</strong></div>
                                        </td>
                                        <td>
                                            {{ $product->description }}
                                            <div>
                                                <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">

                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="{{ Gate::allows('syncProductsCollection') ? '5' : '4' }}">
                                        <div class="pull-right">{!! $products->links() !!}</div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            </form>
                        </div>
                    </div>
            </div>

    @can('destroyProductCategory')
    @section('category-delete_inputs')
        <input name="cat_id" type="hidden"/>
    @endsection
    @include('admin.partials._prompt',[
        'id' => 'category-delete',
        'method' => 'post',
        'action' => URL::action('ProductCategoriesController@destroy'),
        'title' => 'Xác nhận',
        'message' => 'Bạn có chắc chắn muốn xóa nhóm sản phẩm "<span class="cat_name">này</span>" hay không?',
    ])
    @endcan
@endsection



@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });

        $('#modal-category-delete-prompt').on('show.bs.modal', function(e) {
            $(e.currentTarget).find('input[name="cat_id"]').val($(e.relatedTarget).data('cat_id'));
            $(e.currentTarget).find('span.cat_name').text($(e.relatedTarget).data('cat_name'));
        });

        $('#select_all').on('ifToggled', function(event){
            $('input[name="detach_product_id[]"').iCheck('toggle');
        });
        $("#product_id").select2({
            placeholder: "Thêm sản phẩm vào nhóm",
            ajax: {
                url: '{{ URL::action('ProductsController@queryProducts') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function (data, params) {
                    $.map(data, function (data) {
                        data.id = data.id;
                        data.text = data.name;
                        data.url = data.url
                    });
                    return {
                        results: data
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 3,
            templateResult: function (item) {
                if (item.loading) return item.text;
                console.log(item.image);
                markup = '<div><img src="'+ item.image + '" style="width:40px; height: 60px; background: grey" /><span> ' + item.text + '</span></div>';
                return markup;
            },
            templateSelection: function (item) {
                return '<option data-url="' + item.url + '" style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
            }
        });
    </script>
@endsection